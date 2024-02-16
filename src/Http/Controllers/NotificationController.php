<?php

namespace Raim\FluxNotify\Http\Controllers;

use Raim\FluxNotify\Helpers\NotificationHelper;
use Raim\FluxNotify\Helpers\SendNotificationHelper;
use Raim\FluxNotify\Http\Resources\NotificationResource;

use Illuminate\Http\Request;
use Raim\FluxNotify\Models\SentPushNotification;

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

    public function getNotificationsBySlug($slug)
    {
        $user = auth('sanctum')->user();

        $notifications = config('flux-notification.models.user')::findOrFail($user->id)
            ->sentPushNotifications()
            ->whereHas('notificationType', fn($query) => $query->where('slug', $slug))
            ->with('pushable')
            ->isNotOld()
//            ->when($slug != SendNotificationHelper::NOTIFICATION_TYPE_NEWS, fn($query) => $query->has('order')->with('order'))
            ->orderByRaw("CASE WHEN sent_push_notifications.status!='" . NotificationHelper::STATUS_READ . "'THEN 1 ELSE 2 END ASC")
            ->orderBy("created_at", "desc")
            ->get();

        return NotificationResource::collection($notifications)->additional(['success' => true]);
    }

    public function getNotifications(Request $request)
    {
        $user = auth('sanctum')->user();

        $notifications = SentPushNotification::whereUserId($user->id)
            ->isNotOld()
            ->with('pushable')
            ->orderByRaw("CASE WHEN status!='" . NotificationHelper::STATUS_READ . "'THEN 1 ELSE 2 END ASC")
            ->orderBy("created_at", "desc")
            ->paginate($request->input('per_page', 20));

        return NotificationResource::collection($notifications)->additional(['success' => true]);
    }

    public function updateUnread(Request $request, $slug = null)
    {
        $user = auth('sanctum')->user();
        config('flux-notification.models.sent_push_notification')::query()
            ->where('status', NotificationHelper::STATUS_UNREAD)
            ->when(!empty($slug), fn($query) => $query->whereHas('notificationType', fn($query) => $query->where('slug', $slug)))
            ->where('user_id', $user->id)
            ->update([
                'status' => NotificationHelper::STATUS_READ
            ]);
        return response()->noContent();
    }

    public function updateUnreadBySlug($slug, Request $request)
    {
        $user = auth('sanctum')->user();
        config('flux-notification.models.sent_push_notification')::query()
            ->where('status', NotificationHelper::STATUS_UNREAD)
            ->whereHas('notificationType', fn($query) => $query->where('slug', $slug))
            ->where('user_id', $user->id)
            ->update([
                'status' => NotificationHelper::STATUS_READ
            ]);
        return response()->noContent();
    }

    public function destroy($id, Request $request)
    {
        $user = auth('sanctum')->user();
        config('flux-notification.models.sent_push_notification')::where('user_id', $user->id)
            ->where('id', $id)
            ->delete();
        return response()->noContent();
    }
}
