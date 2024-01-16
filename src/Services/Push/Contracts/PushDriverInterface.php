<?php

namespace Raim\FluxNotify\Services\Push\Contracts;

use Raim\FluxNotify\Services\Push\Classes\PushNotification;

interface PushDriverInterface
{
    public function notify(PushNotification $push);
}
