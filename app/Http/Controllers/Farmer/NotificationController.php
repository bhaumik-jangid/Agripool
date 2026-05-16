<?php

namespace App\Http\Controllers\Farmer;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::where('user_id', Auth::id())
                            ->orderBy('created_at', 'desc')
                            ->paginate(15);

        // Mark all as read when viewing the page
        Notification::where('user_id', Auth::id())
                    ->where('is_read', false)
                    ->update(['is_read' => true]);

        return view('farmer.notifications.index', compact('notifications'));
    }

    public function markRead($id)
    {
        Notification::where('id', $id)
                    ->where('user_id', Auth::id())
                    ->update(['is_read' => true]);

        return back();
    }

    public function markAllRead()
    {
        Notification::where('user_id', Auth::id())
                    ->update(['is_read' => true]);

        return back()->with('success', 'All notifications marked as read.');
    }
}