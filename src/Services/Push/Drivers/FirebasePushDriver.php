<?php

namespace Raim\FluxNotify\Push\Drivers;

use Raim\FluxNotify\Helpers\DeviceTokenHelper;
use Raim\FluxNotify\Push\Classes\PushNotification;
use Raim\FluxNotify\Push\Contracts\PushDriverInterface;
use Illuminate\Support\Facades\Http;

class FirebasePushDriver implements PushDriverInterface
{
    public function notify(PushNotification $push)
    {
        $data = $this->prepare($push);

        $headers = [
            'Authorization' => 'key=' .(config('flux-notification.options.firebase_key')),
            'Content-Type'  => 'application/json',
        ];
        $response  = Http::withHeaders($headers)
            ->post(config('flux-notification.options.firebase_url'), $data)->json();
        return [ $response,DeviceTokenHelper::DRIVER_FIREBASE];
    }

    public function prepare(PushNotification $push) {
        $tokens = $push->getReceiver()
            ->deviceTokens()
            ->whereNotNull('device_token')
            ->get()->pluck('device_token')->toArray();

        return [
            "registration_ids" => $tokens,
            "notification" => [
                "title" => $push->subject,
                "body"  => $push->text,
                "sound"  => $push->sound,
            ],
            'data' => $push->extra
        ];
    }
}
