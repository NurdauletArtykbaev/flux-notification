<?php

namespace Raim\FluxNotify\Helpers;

class OrderHelper
{
//    const STATUS_NEW = 0;
//    const STATUS_ACCEPTED = 1;
//    const STATUS_ACTIVE =2 ;
//    const STATUS_CANCELLED = 4;
//    const STATUS_FINISHED = 5;


    /* CLIENT_PROCESSING, LORD_NEW_ORDER */
    //    const TEST_GENERAL_PROCESSING = 0;
    const STATUS_NEW = 0;
    const SERVICE_COMMISSION_PERCENTAGE = 15;
    /* LORD_ACCEPTED = 1 , CLIENT_ACCEPTED = 1 */
    const STATUS_ACCEPTED = 1;
    /* LORD_ISSUED = 2, CLIENT_RECEIVED = 2*/
    const STATUS_ACTIVE = 2;
    /* ? * */
    const STATUS_HISTORY = 3;
    /* client, lord cancelled */
//    const STATUS_CLIENT_CANCELED = 4;
    const STATUS_CANCELED = 4;
    /* Order::LORD_GOT = 4, Order::CLIENT_RETURNED = 4*/
    const STATUS_FINISHED = 5;
    const STATUS_EXPIRED = 6;
    const CANCELLED_ORDER_COUNT_LIMIT = 5;


    const STATUSES = [
        self::STATUS_NEW       => 'Новый',
        self::STATUS_ACCEPTED  => 'Принят',
        self::STATUS_ACTIVE    => 'Активный',
        self::STATUS_HISTORY    => 'История',
//        self::STATUS_CLIENT_CANCELED => 'Отменен (клиент)',
        self::STATUS_CANCELED => 'Отменен',
        self::STATUS_FINISHED  => 'Завершен',
        self::STATUS_EXPIRED  => 'Срок истек',
    ];

    public static function calcCommissionService($amount)
    {
        return round($amount *  self::SERVICE_COMMISSION_PERCENTAGE / 100) ;

    }
//
//    public function getAcceptedDate()
//    {
//
//    }
}
