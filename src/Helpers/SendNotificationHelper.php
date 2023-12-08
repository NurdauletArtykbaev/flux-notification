<?php

namespace Raim\FluxNotify\Helpers;

use OpenApi\Attributes\Head;

class SendNotificationHelper
{
    const TYPE_LORD = 1;
    const TYPE_CLIENT = 2;
    const TYPE_NEWS = 3;

    public function getTypes()
    {
        return [
            self::TYPE_LORD => 'Арендодатель',
            self::TYPE_CLIENT => 'Клиент',
            self::TYPE_NEWS => 'Новости'
        ];
    }

    const NOTIFICATION_TYPE_CLIENT = 'client';
    const NOTIFICATION_TYPE_STORE = 'store';
    const NOTIFICATION_TYPE_NEWS = 'news';
}
