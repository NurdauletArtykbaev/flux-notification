<?php

namespace Raim\FluxNotify\Http\Controllers;

use Raim\FluxNotify\Helpers\NotificationHelper;
use Raim\FluxNotify\Helpers\SendNotificationHelper;
use Raim\FluxNotify\Http\Resources\NotificationResource;

use Illuminate\Http\Request;

class NotificationController
{

    public function getUnread(Request $request)
    {
        $user = $request->user();

        $unreadNotifications = config('flux-notification.models.sent_push_notification')::query()
            ->where('status', NotificationHelper::STATUS_UNREAD)
            ->where('user_id', $user->id)
            ->count();

        return response()->json([

            'data' => ['count' => $unreadNotifications]
        ]);
    }

    public function getUserNotifications($slug)
    {
        $user = auth('sanctum')->user();

        $notifications = config('flux-notification.models.user')::findOrFail($user->id)->sentPushNotifications()
            ->whereHas('notificationType', fn($query) => $query->where('slug', $slug))
            ->isNotOld()
//            ->when($slug != SendNotificationHelper::NOTIFICATION_TYPE_NEWS, fn($query) => $query->has('order')->with('order'))
            ->orderByRaw("CASE WHEN sent_push_notifications.status!='" . NotificationHelper::STATUS_READ . "'THEN 1 ELSE 2 END ASC")
            ->orderBy("created_at", "desc")
            ->get();

        return NotificationResource::collection($notifications)->additional(['success' => true]);
    }

    public function getNotifications()
    {
        $user = auth('sanctum')->user();

        $notifications = config('flux-notification.models.user')::findOrFail($user->id)->sentPushNotifications()
            // ->whereHas('notificationType', fn($query) => $query->where('slug', $slug))
            ->isNotOld()
            // ->when($slug != SendNotificationHelper::NOTIFICATION_TYPE_NEWS, fn($query) => $query->has('order')->with('order'))
            ->orderByRaw("CASE WHEN sent_push_notifications.status!='" . NotificationHelper::STATUS_READ . "'THEN 1 ELSE 2 END ASC")
            ->orderBy("created_at", "desc")
            ->get();

        return NotificationResource::collection($notifications)->additional(['success' => true]);
    }

    public function updateUnread(Request $request)
    {
        $user = $request->user();
        $type = $request->input('type');
        $unreadNotifications = config('flux-notification.models.sent_push_notification')::query()
            ->where('status', NotificationHelper::STATUS_UNREAD)
            ->where('user_id', $user->id)
            ->when(!empty($type), fn($query) => $query->whereHas('notificationType', fn($query) => $query->where('slug', $type)))
            ->get();


        if (isset($request->notifacation_ids) && is_array($request->notifacation_ids)) {
            config('flux-notification.models.sent_push_notification')::whereIn('id', $request->notifacation_ids)->update(['status' => NotificationHelper::STATUS_READ]);
        } else {
            foreach ($unreadNotifications as $notification) {
                $notification->status = NotificationHelper::STATUS_READ;
                $notification->save();
            }
        }

        return response()->noContent();
    }
}
