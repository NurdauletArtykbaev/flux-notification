<?php
return [
    'table_names'=> [
    ],
    'models' => [
        'notification' => \Raim\FluxNotify\Models\Notification::class,
        'notification_type' => \Raim\FluxNotify\Models\NotificationType::class,
        'order' => \Raim\FluxNotify\Models\Order::class,
        'device_token' => \Raim\FluxNotify\Models\DeviceToken::class,
        'quick_notification' => \Raim\FluxNotify\Models\QuickNotification::class,
        'sent_push_notification' => \Raim\FluxNotify\Models\SentPushNotification::class,
        'user' => \Raim\FluxNotify\Models\User::class,
    ],
    'languages' => [
        'ru', 'en', 'kk'
    ],
    'options' => [
        'firebase_key' => env('FCM_SERVER_KEY'),
        'firebase_url' => env('FCM_SERVER_URL', 'https://fcm.googleapis.com/fcm/send'),
    ],
];
