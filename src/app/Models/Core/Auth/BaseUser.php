<?php

namespace App\Models\Core\Auth;

use Altek\Eventually\Eventually;
use App\Models\Core\Auth\Traits\SendUserPasswordReset;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Class BaseUser.
 */
abstract class BaseUser extends Authenticatable
{
    use Eventually,
        Notifiable,
        SendUserPasswordReset,
        SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'active',
        'last_login_at',
        'created_by',
        'status_id',
        'invitation_token',
        'api_token',
        'lang',
    ];

    /**
     * The dynamic attributes from mutators that should be returned with the user object.
     * @var array
     */
    protected $appends = [
        'full_name',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'api_token'
    ];

    /**
     * Show user name with link to user detail.
     *
     * @return \Illuminate\Support\HtmlString
     */
    public function nameLink()
    {
        return link_to_route('users.show', $this->full_name, [$this]);
    }

    /**
     * A user may have multiple roles.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function roles()
    {
        return $this->hasMany(UserRole::class);
    }

   

    /**
     * Assign the given role to the user.
     *
     * @param  string  $roleName
     * @return void
     */
    public function assignRole(string $roleName)
    {
        $roleId = Role::getIdByName($roleName);

        UserRole::create([
            'user_id' => $this->id,
            'role_id' => $roleId,
        ]);
    }

    /**
     * Remove the given role from the user.
     *
     * @param  string  $roleName
     * @return void
     */
    public function removeRole(string $roleName)
    {
        $roleId = Role::getIdByName($roleName);

        \DB::table('user_roles')->where([
            'user_id' => $this->id,
            'role_id' => $roleId,
        ])->delete();
    }

    /**
     * Determine if the user has the given role.
     *
     * @param  string  $roleName
     * @return bool
     */
    public function hasRole(string $roleName)
    {
        $roleId = Role::getIdByName($roleName);

        return $this->roles->contains('role_id', $roleId);
    }

    /**
     * Determine if the user has the given array of roles.
     *
     * @param  array  $roleNameArray
     * @return bool
     */
    public function hasRoles(array $roleNameArray)
    {
        return $this->roles->pluck('role_id')
            ->contains(function ($roleId, $key) use ($roleNameArray) {
                $roleIds = [];

                foreach ($roleNameArray as $roleName) {
                    $roleIds[] = Role::getIdByName($roleName);
                }

                return in_array($roleId, $roleIds);
            });
    }

    /**
     * User query scope based on role names.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  array  $roleNameArray
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeHasRoles($query, array $roleNameArray)
    {
        return $query->whereHas('roles', function ($q) use ($roleNameArray) {
            $roleIds = [];

            foreach ($roleNameArray as $roleName) {
                $roleIds[] = Role::getIdByName($roleName);
            }

            $q->whereIn('role_id', $roleIds);
        });
    }

    /**
     * List of user roles in HTML list items.
     *
     * @return string
     */
    public function roleList()
    {
        $roleList = '<ul>';
        foreach ($this->roles as $role) {
            $roleList .= '<li>'.$role->name.'</li>';
        }
        $roleList .= '</ul>';

        return $roleList;
    }

    /**
     * User has many Jobs relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function jobs()
    {
        return $this->hasMany('App\Models\ProjectManagement\Projects\ProjectJobs', 'worker_id');
    }

    /**
     * User belongs to many Projects based on Job assignments.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function projects()
    {
        return $this->belongsToMany('App\Models\ProjectManagement\Projects\Project', 'ProjectJobs', 'worker_id')
            ->groupBy('worker_id')
            ->groupBy('project_id');
    }

    /**
     * Return true or false if the user can impersonate another user.
     *
     * @return bool
     */
    public function canImpersonate()
    {
        return $this->isAdmin();
    }

    /**
     * Return true or false if the user can be impersonated.
     *
     * @return bool
     */
    public function canBeImpersonated()
    {
        return $this->id !== 1;
    }

    /**
     * Get the user's full name.
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    
}
