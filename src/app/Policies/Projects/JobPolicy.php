<?php

namespace App\Policies\Projects;

use App\Models\ProjectManagement\Projects\ProjectJob;
use App\Models\Core\Auth\User;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * ProjectJob model policy class.
 *
 * @author Nafies Luthfi <nafiesL@gmail.com>
 */
class JobPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the ProjectJob.
     *
     * @param  \App\Models\ProjectManagement\Users\User  $user
     * @param  \App\Models\ProjectManagement\Projects\ProjectJob  $job
     * @return mixed
     */
    public function view(User $user, ProjectJob $job)
    {
        return $user->hasRole('admin')
            || ($user->hasRole('worker') && $job->worker_id == $user->id);
    }

    /**
     * Determine whether the user can create jobs.
     *
     * @param  \App\Models\ProjectManagement\Users\User  $user
     * @param  \App\Models\ProjectManagement\Projects\Job  $job
     * @return mixed
     */
    public function create(User $user,ProjectJob $job)
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can update theProjectJob.
     *
     * @param  \App\Models\ProjectManagement\Users\User  $user
     * @param  \App\Models\ProjectManagement\Projects\Job  $job
     * @return mixed
     */
    public function update(User $user,ProjectJob $job)
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can delete theProjectJob.
     *
     * @param  \App\Models\ProjectManagement\Users\User  $user
     * @param  \App\Models\ProjectManagement\Projects\Job  $job
     * @return mixed
     */
    public function delete(User $user,ProjectJob $job)
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can seeProjectJob pricings.
     *
     * @param  \App\Models\ProjectManagement\Users\User  $user
     * @param  \App\Models\ProjectManagement\Projects\Job  $job
     * @return mixed
     */
    public function seePricings(User $user,ProjectJob $job)
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can viewProjectJob comments.
     *
     * @param  \App\Models\ProjectManagement\Users\User  $user
     * @param  \App\Models\ProjectManagement\Projects\Job  $job
     * @return bool
     */
    public function viewComments(User $user,ProjectJob $job)
    {
        // Admin andProjectJob workers can commenting on theirProjectJob.
        return $user->hasRole('admin')
            || ($user->hasRole('worker') && $job->worker_id == $user->id);
    }

    /**
     * Determine whether the user can add comment to aProjectJob.
     *
     * @param  \App\Models\ProjectManagement\Users\User  $user
     * @param  \App\Models\ProjectManagement\Projects\Job  $job
     * @return bool
     */
    public function commentOn(User $user,ProjectJob $job)
    {
        // Admin and job workers can commenting on their job.
        return $this->viewComments($user, $job);
    }
}
