<?php



namespace App\Models\CRM\Company;


use Illuminate\Database\Eloquent\Model;
use App\Models\CRM\Objective\traits\HasObjectiveTrait;
use App\Models\CRM\Avatar\traits\HasAvatarTrait;
use App\Models\CRM\Follow\traits\HasFollowTrait;
use App\Interfaces\HasObjectiveInterface;
use App\Models\CRM\Ticket\Ticket;
use App\Models\Core\Auth\User;
use App\Interfaces\HasInvitationInterface;
// use App\Traits\HasInvitationTrait;
// use App\Traits\HasPermissionTrait;
// use App\Traits\HasMemberTrait;

class Company extends Model implements HasObjectiveInterface, HasInvitationInterface
{
    use HasObjectiveTrait, HasAvatarTrait, HasFollowTrait;

    protected $fillable = [
        'name', 'description', 'user_id',
    ];

    public function users()
    {
        return $this->hasMany('App\Models\Core\Auth\User', 'company_id');
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }


    public function departments()
    {
        return $this->hasMany('App\Department', 'company_id');
    }

    public function projects()
    {
        return $this->hasMany(App\Models\ProjectManagement\Projects\Project::class);
    }

    public function getOKrRoute()
    {
        return route('company.okr');
    }

    public function getNotifiableUser()
    {
        foreach ($this->permissions->where('role_id', '=>', '1') as $index => $permission) {
            $users = [$index => $permission->user];
        }
        return $users;
    }

    public function admin()
    {
        return $this->belongsTo(User::class);
    }

    public function getInviteUrl($userId)
    {
        return route('company.index');
    }

    public function delete()
    {   
        foreach ($this->projects as $project) {
            $project->delete();
        }
        foreach ($this->users as $user) {
            $user->update(['company_id' => null, 'department_id' => null]);
        }
        foreach ($this->departments as $department) {
            $department->preDelete();
        }
        Permission::where(['model_type'=>Company::class, 'model_id'=>$this->id])->delete();
        $this->follower()->delete();

        return parent::delete();
    }

}
