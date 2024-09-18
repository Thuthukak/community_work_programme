<?php

namespace App\Models\Core\Auth\Traits;

use Illuminate\Auth\Notifications\ResetPassword as ResetPasswordNotification;


/**
 * Class SendUserPasswordReset.
 */
trait SendUserPasswordReset
{
    /**
     * Send the password reset notification.
     *
     * @param string $token
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));

    }
}
