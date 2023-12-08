<?php

namespace Raim\FluxNotify\Push\Channels;

use Illuminate\Notifications\Notification;

class SmsChannel
{
    public function send($notifiable, Notification $notification) {
        // return $notification->toPush()->to($notifiable)->send();
    }
}
