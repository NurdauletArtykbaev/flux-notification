<?php

namespace Raim\FluxNotify\Facades;

use Illuminate\Support\Facades\Facade;

class PushFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'fluxPushService';
    }
}
