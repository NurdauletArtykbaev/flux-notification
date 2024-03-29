<?php

namespace Raim\FluxNotify\Services\Push;

use Raim\FluxNotify\Services\Push\Classes\PushNotification;
use Raim\FluxNotify\Services\Push\Contracts\PushDriverInterface;

class PushService
{
    public function __construct(private PushDriverInterface $driver)
    {
    }

    public function notify(PushNotification $push)
    {
        $response = $this->driver->notify($push);
        return $push->handleResponse($response);
    }

    public function __call($method, array $parameters = [])
    {
        return $this->driver->{$method}(...$parameters);
    }
}
