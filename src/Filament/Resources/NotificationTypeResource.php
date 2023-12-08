<?php

namespace Raim\FluxNotify\Filament\Resources;

use Raim\FluxNotify\Filament\Resources\NotificationTypeResource\Pages;
use Raim\FluxNotify\Filament\Resources\NotificationTypeResource\RelationManagers;
use Raim\FluxNotify\Helpers\LangHelper;
use Raim\FluxNotify\Models\NotificationType;
use Filament\Forms;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class NotificationTypeResource extends Resource
{
    use Translatable;

    public static function getModel(): string
    {
        return config('flux-notification.models.notification_type');
    }

    public static function getModelLabel(): string
    {
        return trans('flux-notification.notification_type.singular');
    }

    public static function getPluralModelLabel(): string
    {
        return trans('flux-notification.notification_type.plural');
    }

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function getTranslatableLocales(): array
    {
        return LangHelper::LANGUAGES;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label(trans('flux-notification.notification_type.fields.name')),
                Forms\Components\TextInput::make('slug')
                    ->label(trans('flux-notification.notification_type.fields.key')),
                Forms\Components\Toggle::make('is_active')
                    ->label(trans('flux-notification.notification_type.fields.is_active')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(trans('flux-notification.notification_type.fields.name')),
                Tables\Columns\TextColumn::make('slug')
                    ->label(trans('flux-notification.notification_type.fields.key')),
                Tables\Columns\BooleanColumn::make('is_active')->label(trans('flux-notification.notification_type.fields.is_active')),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListNotificationTypes::route('/'),
            'create' => Pages\CreateNotificationType::route('/create'),
            'edit' => Pages\EditNotificationType::route('/{record}/edit'),
        ];
    }
}
