<?php

namespace Raim\FluxNotify\Filament\Resources\NotificationResource\Pages;

use Raim\FluxNotify\Filament\Resources\NotificationResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditNotification extends EditRecord
{
    protected static string $resource = NotificationResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
