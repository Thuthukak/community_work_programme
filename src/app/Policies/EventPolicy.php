<?php

namespace App\Policies;

use App\Models\ProjectManagement\Users\Event;
use App\Models\Core\Auth\User;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Event model policy class.
 *
 * @author Nafies Luthfi <nafiesL@gmail.com>
 */
class EventPolicy
{
    use HandlesAuthorization;

    public function update(User $user, Event $event)
    {
        return $user->id == $event->user_id;
    }

    public function delete(User $user, Event $event)
    {
        return $user->id == $event->user_id;
    }
}
