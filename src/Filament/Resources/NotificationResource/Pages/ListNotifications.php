<?php

namespace Raim\FluxNotify\Filament\Resources\NotificationResource\Pages;

use Raim\FluxNotify\Filament\Resources\NotificationResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListNotifications extends ListRecords
{
    protected static string $resource = NotificationResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
