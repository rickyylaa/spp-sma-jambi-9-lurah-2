<?php

namespace App\Http\Controllers\Operator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Notification as Notif;

class NotificationController extends Controller
{
    public function markAsRead(Request $request)
    {
        $notificationId = $request->input('id');
        Notif::where('id', $notificationId)->update(['is_read' => 1]);
        return response()->json(['success' => true]);
    }

    public function markAllAsRead()
    {
        Notif::where('is_read', 0)->update(['is_read' => 1]);
        return response()->json(['success' => true]);
    }
}
