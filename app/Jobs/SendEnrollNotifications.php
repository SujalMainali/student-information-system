<?php

namespace App\Jobs;

use App\Notifications\EnrollRequestNotification;
use App\Models\EnrollmentRequest;
use App\Models\User;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Notification;

class SendEnrollNotifications implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public EnrollmentRequest $enrollmentRequest
    )
    {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $admins = User::where('role','admin')->get();
        Notification::send($admins, new EnrollRequestNotification($this->enrollmentRequest));
    }
}
