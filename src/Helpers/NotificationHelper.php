<?php

namespace Raim\FluxNotify\Helpers;

class NotificationHelper
{
    const STATUS_UNREAD    = 0;
    const STATUS_READ      = 1;
    const STATUS_FAILED    = 2;

    CONST LORD_ORDER_NEW = 'lord_order_new';
    CONST CLIENT_ORDER_ACCEPT = 'client_order_accept';
    CONST LORD_ORDER_ACCEPT = 'lord_order_accept';
    CONST CLIENT_ORDER_ISSUE = 'client_order_issue';
    CONST LORD_ORDER_ISSUE = 'lord_order_issue';
    CONST CLIENT_ORDER_RECEIVE = 'client_order_receive';
    CONST LORD_ORDER_GOT = 'lord_order_got';
    CONST CLIENT_ORDER_CANCEL = 'client_order_cancel';
    CONST LORD_ORDER_CANCEL = 'lord_order_cancel';
    CONST LORD_VERIFIED = 'lord_verified';
    CONST LORD_BALANCE_TOP_UP = 'lord_balance_top_up';
    CONST LORD_BALANCE_DEBITING = 'lord_balance_debiting';
    CONST CLIENT_BALANCE_BONUS_FOR_REGISTER = 'client_balance_bonus_for_register';

//    const KEY_NEW_ORDER = 'new_order';

}
