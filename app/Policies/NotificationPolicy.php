<?php

namespace App\Policies;

use App\Models\User;

use Illuminate\Notifications\DatabaseNotification;

class NotificationPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function markRead(User $user, DatabaseNotification $notification): bool
    {
        return $notification->notifiable_id === $user->id;
    }
}
