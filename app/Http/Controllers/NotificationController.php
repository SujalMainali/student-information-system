<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Gate;

class NotificationController extends Controller
{
    public function index()
    {
        $pageNotifications = auth()->user()->notifications()->paginate(10);

        return view('notifications.index', compact('pageNotifications'));
    }

    public function show(DatabaseNotification $notification)
    {
        return view('notifications.show', compact('notification'));
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

    public function markAllRead()
    {
        auth()->user()->unreadNotifications->markAsRead();

        if (request()->expectsJson()) {
            return response()->json(['message' => 'All notifications marked as read.']);
        }

        return redirect()->back()->with('success', 'All notifications marked as read.');
    }
}
