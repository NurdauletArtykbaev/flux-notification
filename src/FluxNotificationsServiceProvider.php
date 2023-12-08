<?php

namespace Raim\FluxNotify;

use Filament\Facades\Filament;
use Filament\Navigation\NavigationBuilder;
use Filament\Navigation\NavigationGroup;
use Illuminate\Support\ServiceProvider;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Collection;
use Raim\FluxNotify\Push\Contracts\PushDriverInterface;
use Raim\FluxNotify\Push\Drivers\FirebasePushDriver;

class FluxNotificationsServiceProvider extends ServiceProvider
{
    public $bindings = [
        //PushDriverInterface::class => ExpoPushDriver::class,
        PushDriverInterface::class => FirebasePushDriver::class
    ];

    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishConfig();
            $this->publishMigrations();
            $this->publishLang();
        }
        $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');
    }

    public function register()
    {
        $this->app->bind('fluxPushService', PushService::class);
    }

    public function publishLang()
    {
        $this->publishes([
            __DIR__ . '/../lang/flux-notification.php' =>  $this->app->langPath('ru/flux-notification.php'),
        ], 'flux-notification-config');
    }

    protected function publishConfig()
    {
        $this->publishes([
            __DIR__ . '/../config/flux-notification.php' => config_path('flux-notification.php'),
        ], 'flux-notification-config');
    }

    protected function publishMigrations()
    {
        $this->publishes([
            __DIR__ . '/../database/migrations/check_device_tokens_table.php.stub' => $this->getMigrationFileName('00','check_flux_notify_device_tokens_table.php'),
            __DIR__ . '/../database/migrations/check_notification_types_table.php.stub' => $this->getMigrationFileName('00','check_flux_notify_notification_types_table.php'),
            __DIR__ . '/../database/migrations/check_notifications_table.php.stub' => $this->getMigrationFileName('01','check_flux_notify_notifications_table.php'),
            __DIR__ . '/../database/migrations/check_quick_notifications_table.php.stub' => $this->getMigrationFileName('02','check_flux_notify_quick_notifications_table.php'),
            __DIR__ . '/../database/migrations/check_sent_push_notifications_table.php.stub' => $this->getMigrationFileName('03','check_flux_notify_sent_push_notifications_table.php'),
        ], 'flux-notification-migrations');
    }
        
    /**
     * Returns existing migration file if found, else uses the current timestamp.
     */
    protected function getMigrationFileName($index,string $migrationFileName): string
    {
        $timestamp = date('Y_m_d_His');

        $filesystem = $this->app->make(Filesystem::class);

        return Collection::make([$this->app->databasePath() . DIRECTORY_SEPARATOR . 'migrations' . DIRECTORY_SEPARATOR])
            ->flatMap(fn($path) => $filesystem->glob($path . '*_' . $migrationFileName))
            ->push($this->app->databasePath() . "/migrations/{$timestamp}{$index}_{$migrationFileName}")
            ->first();
    }
}
