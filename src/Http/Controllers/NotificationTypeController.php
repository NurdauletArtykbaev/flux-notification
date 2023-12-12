<?php

namespace Raim\FluxNotify\Http\Controllers;

use Raim\FluxNotify\Helpers\NotificationHelper;
use Raim\FluxNotify\Http\Resources\NotificationTypeResource;
use Raim\FluxNotify\Models\NotificationType;

class NotificationTypeController
{
    public function index()
    {
        $user = auth('sanctum')->user();
        $query = config('flux-notification.models.notification_type')::query();
        if ($user) {
            $query->withCount([
                'sentPushNotifications' => fn($query) => $query
                    ->isNotOld()
                    ->where('status', NotificationHelper::STATUS_UNREAD)
                    ->where('user_id', $user->id)
            ])->with([
                'sentPushNotifications' => fn($query) => $query->isNotOld()
                    ->where('user_id', $user->id)
                    ->with('pushable')
                    ->latest()
                    ->limit(1)
            ]);
        }

        return NotificationTypeResource::collection($query->get());
    }
}
