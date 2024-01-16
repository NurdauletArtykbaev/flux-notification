Пакет flux-notify - Уведомления.

Установите пакет с помощью Composer:
``` bash
 composer require nurdaulet/flux-notification
```

## Конфигурация
После установки пакета, вам нужно опубликовать конфигурационный файлы. Вы можете сделать это с помощью следующей команды:

``` bash
php artisan vendor:publish --provider="Raim\FluxNotify\FluxNotificationsServiceProvider"
php artisan vendor:publish --tag flux-notification-config
```