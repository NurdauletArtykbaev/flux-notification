<?php

namespace Raim\FluxNotify\Push\Contracts;

use Raim\FluxNotify\Push\Classes\PushNotification;

interface PushDriverInterface
{
    public function notify(PushNotification $push);
}
