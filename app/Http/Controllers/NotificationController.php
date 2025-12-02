<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Http\Request;
use app\Enums\NotificationType;

class NotificationController extends Controller
{
    public function markNotificationsAsRead() 
    {
        Auth::user()
        ->notifications()
        ->where('acknowledged', false)
        ->update(['acknowledged' => true]);

        return back()->with('success', 'All notifications marked as read.');
    }
}
