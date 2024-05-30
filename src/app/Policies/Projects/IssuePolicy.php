<?php

namespace App\Policies\Projects;

use App\Models\ProjectManagement\Projects\Issue;
use App\Entities\Users\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class IssuePolicy
{
    use HandlesAuthorization;

    public function create(User $user, Issue $issue)
    {
        return true;
    }

    /**
     * Determine whether the user can add comment to an issue.
     *
     * @param  \App\Entities\Users\User  $user
     * @param  \App\Models\ProjectManagement\Projects\Issue  $issue
     * @return bool
     */
    public function commentOn(User $user, Issue $issue)
    {
        return true;
    }
}
