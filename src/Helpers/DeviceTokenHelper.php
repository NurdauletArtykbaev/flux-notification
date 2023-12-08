<?php

namespace Raim\FluxNotify\Helpers;

class DeviceTokenHelper
{
    const PLATFORM_ANDROID = 1;
    const PLATFORM_IOS     = 2;
    const PLATFORM_MOBILE  = 3;
    const PLATFORM_WEB     = 4;
    const DRIVER_FIREBASE  = 'firebase';
    const DRIVER_EXPO      = 'expo';
    public static function getPlatform($platform = null)
    {
        switch ($platform) {
            case 'ios': {
                return self::PLATFORM_IOS;
            }
            case 'android': {
                return self::PLATFORM_ANDROID;
            }
            case 'mobile': {
                return self::PLATFORM_MOBILE;
            }
            default:   {
                return self::PLATFORM_WEB;
            }
        }
    }
    public static function getPlatformByNumber($platform = null)
    {
        switch ($platform) {
            case 1: {
                return 'android';
            }
            case 2: {
                return 'ios';
            }
            case 3: {
                return 'mobile';
            }
            default:   {
                return "Сайт";
            }
        }
    }
}
