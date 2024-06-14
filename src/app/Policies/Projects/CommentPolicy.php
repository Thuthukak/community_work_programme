<?php

namespace App\Policies\Projects;

use App\Models\ProjectManagement\Projects\Comment;
use App\Models\Core\Auth\User;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Comment model policy class.
 *
 * @author Nafies Luthfi <nafiesL@gmail.com>
 */
class CommentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can update the comment.
     *
     * @param  \App\Models\ProjectManagement\Users\User  $user
     * @param  \App\Models\ProjectManagement\Projects\Comment  $comment
     * @return bool
     */
    public function update(User $user, Comment $comment)
    {
        // Only admin and comment creator can update comment.
        return $user->hasRole('admin')
            || ($user->hasRole('worker') && $comment->creator_id == $user->id);
    }

    /**
     * Determine whether the user can delete the comment.
     *
     * @param  \App\Models\ProjectManagement\Users\User  $user
     * @param  \App\Models\ProjectManagement\Projects\Comment  $comment
     * @return bool
     */
    public function delete(User $user, Comment $comment)
    {
        // Only admin and comment creator can delete comment.
        return $this->update($user, $comment);
    }
}
