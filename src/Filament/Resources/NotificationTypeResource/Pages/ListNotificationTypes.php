<?php

namespace Raim\FluxNotify\Filament\Resources\NotificationTypeResource\Pages;

use Raim\FluxNotify\Filament\Resources\NotificationTypeResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListNotificationTypes extends ListRecords
{
    use ListRecords\Concerns\Translatable;
    protected static string $resource = NotificationTypeResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\LocaleSwitcher::make(),
        ];
    }
}
