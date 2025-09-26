<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\NotificationRead;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class NotificationController extends Controller
{
    public function index(): Response
    {
        $now = now();
        $userId = Auth::id();

        $notifications = Notification::query()
            ->where('is_active', true)
            ->where(function ($q) use ($now) {
                $q->whereNull('expires_at')->orWhere('expires_at', '>', $now);
            })
            ->orderByDesc('created_at')
            ->limit(50)
            ->get(['id','title','message','expires_at','created_at']);

        if ($userId) {
            // Mark all fetched notifications as read for this user (idempotent due to unique index)
            foreach ($notifications as $n) {
                NotificationRead::firstOrCreate([
                    'user_id' => $userId,
                    'notification_id' => $n->id,
                ]);
            }
        }

        return Inertia::render('client/Notifications', [
            'notifications' => $notifications,
        ]);
    }
}