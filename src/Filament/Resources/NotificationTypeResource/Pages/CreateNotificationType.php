<?php

namespace Raim\FluxNotify\Filament\Resources\NotificationTypeResource\Pages;

use Raim\FluxNotify\Filament\Resources\NotificationTypeResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateNotificationType extends CreateRecord
{
    use CreateRecord\Concerns\Translatable;
    protected static string $resource = NotificationTypeResource::class;

    protected function getActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),
        ];
    }
}
