<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;
use App\Models\User;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Auth::user()->notifications()->latest()->get();
        return view('notifications.index', compact('notifications'));
    }

    public function markAsRead($id)
{
    $notification = Auth::user()->notifications()->findOrFail($id);
    $notification->markAsRead();
    $notification->delete();
    // Redirect to relevant page (like order detail)
    return redirect()->route('user.dashboard'); // or wherever you want
}
public function markAllAsRead()
{
    $user = Auth::user();
    $user->unreadNotifications->each(function ($notification) {
        $notification->markAsRead();
        $notification->delete();
    });
    return redirect()->route('notifications.index')->with('success', 'All notifications marked as read and deleted.');
}

}
