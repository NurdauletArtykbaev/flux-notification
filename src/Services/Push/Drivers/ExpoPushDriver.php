<?php

namespace Raim\FluxNotify\Push\Drivers;

use Raim\FluxNotify\Helpers\DeviceTokenHelper;
use Raim\FluxNotify\Push\Classes\PushNotification;
use Raim\FluxNotify\Push\Contracts\PushDriverInterface;
use Illuminate\Support\Facades\Http;

class ExpoPushDriver implements PushDriverInterface
{
    const URL = 'https://exp.host/--/api/v2/push/send/';

    public function notify(PushNotification $push)
    {
        $data = $this->prepare($push);
        $response = Http::post(self::URL, $data)->json();
        return [ $response, DeviceTokenHelper::DRIVER_EXPO];
    }

    public function prepare(PushNotification $push) {
        $tokens = $push->getReceiver()->deviceTokens()->get()->pluck('device_token')->toArray();

        return [
            'to'    => $tokens,
            'sound' => 'default',
            'data'  => $push->extra,
            'title' => $push->subject,
            'body'  => $push->text
        ];
    }
}
