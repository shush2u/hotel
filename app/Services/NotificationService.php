<?php

namespace App\Services;

use App\Models\Notification;
use App\Enums\NotificationType;

class NotificationService
{
    public function createNotification(int $userId, string $message, NotificationType $notificationType): Notification
    {
        return Notification::create([
            'user_id' => $userId,
            'notification_type' => $notificationType,
            'message' => $message,
            'acknowledged' => false,
        ]);
    }
}