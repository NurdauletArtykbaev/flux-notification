<?php

namespace Raim\FluxNotify;


use Filament\PluginServiceProvider;
use Raim\FluxNotify\Filament\Resources\NotificationResource;
use Raim\FluxNotify\Filament\Resources\NotificationTypeResource;
use Spatie\LaravelPackageTools\Package;

class FluxNotificationsFilamentServiceProvider extends PluginServiceProvider
{
    protected array $resources = [
        NotificationResource::class,
        NotificationTypeResource::class,
    ];

    public function configurePackage(Package $package): void
    {
        $this->packageConfiguring($package);
        $package->name('notifications-package');
    }
}
