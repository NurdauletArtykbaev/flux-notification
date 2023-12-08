<?php

namespace Raim\FluxNotify\Filament\Resources\NotificationTypeResource\Pages;

use Raim\FluxNotify\Filament\Resources\NotificationTypeResource;
use Raim\FluxNotify\Filament\Resources\PaymentMethodResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditNotificationType extends EditRecord
{
    use EditRecord\Concerns\Translatable;
    protected static string $resource = NotificationTypeResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\LocaleSwitcher::make(),
        ];
    }
}
