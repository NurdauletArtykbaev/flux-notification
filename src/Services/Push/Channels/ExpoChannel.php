<?php

namespace Raim\FluxNotify\Push\Channels;

use Illuminate\Notifications\Notification;

class ExpoChannel
{
    public function send($notifiable, Notification $notification) {
        // $notification->toPush($notifiable)->send();
    }
}
