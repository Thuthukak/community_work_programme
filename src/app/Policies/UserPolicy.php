<?php

namespace App\Policies;

use App\Models\Core\Auth\User;
use App\Models\ProjectManagement\Users\User as Worker;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * User model policy class.
 *
 * @author Nafies Luthfi <nafiesL@gmail.com>
 */
class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the user.
     *
     * @param  \App\Models\ProjectManagement\Users\User  $user
     * @param  \App\Models\ProjectManagement\Users\User  $user
     * @return mixed
     */
    public function view(User $user, Worker $worker)
    {
        return true;
    }

    /**
     * Determine whether the user can create users.
     *
     * @param  \App\Models\ProjectManagement\Users\User  $user
     * @param  \App\Models\ProjectManagement\Users\User  $user
     * @return mixed
     */
    public function create(User $user, Worker $worker)
    {
        return true;
    }

    /**
     * Determine whether the user can update the user.
     *
     * @param  \App\Models\ProjectManagement\Users\User  $user
     * @param  \App\Models\ProjectManagement\Users\User  $user
     * @return mixed
     */
    public function update(User $user, Worker $worker)
    {
        return true;
    }

    /**
     * Determine whether the user can delete the user.
     *
     * @param  \App\Models\ProjectManagement\Users\User  $user
     * @param  \App\Models\ProjectManagement\Users\User  $user
     * @return mixed
     */
    public function delete(User $user, Worker $worker)
    {
        return $user->hasRole('admin')
        && $worker->jobs()->count() == 0;
        }
}
