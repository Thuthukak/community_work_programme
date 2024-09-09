<?php

namespace App\Http\Controllers\CRM\TicketNotification;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NotificationController extends Controller
{
    public function index()
    {
        return Auth::user()->notifications()->paginate(5);
    }

    public function allNotification()
    {
        $notifications =  Auth::user()->notifications()->paginate(15);

        return view('notification.index', compact('notifications'));
    }

    public function notificationCount()
    {
        return Auth::user()->unreadNotifications()->count();
    }

    public function notificationRead($id)
    {
        $notification = DB::table('notifications')
            ->where('id', \request()->id)
            ->update([
                'read_at' => now()
            ]);

        return response()->json(['success' => true]);
    }
}
