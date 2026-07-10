<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Gate;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = auth()->user()->notifications->paginate(10);

        return view('notifications.index', compact('notifications'));
    }

    public function markAsRead(DatabaseNotification $notification)
    {
        Gate::authorize('markRead', $notification);
        $notification->markAsRead();

        if (request()->expectsJson()) {
            return response()->json(['message' => 'Notification marked as read.']);
        }

        return redirect()->back()->with('success', 'Notification marked as read.');
    }
}
