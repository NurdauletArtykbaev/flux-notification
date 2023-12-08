<?php

namespace Raim\FluxNotify\Filament\Resources\QuickNotificationResource\Pages;

use Raim\FluxNotify\Filament\Resources\QuickNotificationResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageQuickNotifications extends ManageRecords
{
    protected static string $resource = QuickNotificationResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
