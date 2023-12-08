<?php

namespace Raim\FluxNotify\Traits;

use Raim\FluxNotify\Models\SentPushNotification;
use Raim\FluxNotify\Push\Classes\PushNotification;

trait Pushable
{
    public function sentPushNotifications()
    {
        return $this->morphMany(SentPushNotification::class, 'pushable');
    }

    public function toPush($notifiable = null, $data = [], array $replace = [])
    {
        return new PushNotification($this, $notifiable, $data, $replace);
    }
}
