<?php

namespace Raim\FluxNotify\Filament\Resources;

use Raim\FluxNotify\Filament\Resources\QuickNotificationResource\Pages;
use Raim\FluxNotify\Jobs\Notification\SendQuickNotificationJob;
use Raim\FluxNotify\Models\QuickNotification;
use Filament\Forms;
use Filament\Notifications\Notification;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Actions\BulkAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Actions\Action;
use Illuminate\Database\Eloquent\Collection;

class QuickNotificationResource extends Resource
{
    public static function getModel(): string
    {
        return config('flux-notification.models.quick_notification');
    }

    public static function getModelLabel(): string
    {
        return trans('flux-notification.quick_notification.plural');
    }

    public static function getPluralModelLabel(): string
    {
        return trans('flux-notification.quick_notification.plural');
    }
    protected static ?string $navigationIcon = 'heroicon-o-bell';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('subject')
                    ->required()
                    ->label(trans('flux-notification.quick_notification.fields.subject')),
                Forms\Components\TextInput::make('text')
                    ->required()
                    ->label(trans('flux-notification.quick_notification.fields.text')),
                Forms\Components\TextInput::make('description')
                    ->label(trans('flux-notification.quick_notification.fields.description')),
                Forms\Components\FileUpload::make('image')
                    ->image()
                    ->disk('s3')
                    ->directory('users')
                    ->label(trans('flux-notification.quick_notification.fields.image')),
                Forms\Components\Toggle::make('to_all')
                    ->label(trans('flux-notification.quick_notification.fields.to_all')),
                Forms\Components\Select::make('notification_type_id')
                    ->relationship('notificationType', 'name')
                    ->preload()
                    ->label(trans('flux-notification.notification_type.plural')),
                Forms\Components\Toggle::make('is_active')
                    ->label(trans('flux-notification.quick_notification.fields.is_active'))
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('subject')
                    ->label(trans('admin.subject')),
                Tables\Columns\TextColumn::make('text')
                    ->label(trans('admin.text')),

                Tables\Columns\ImageColumn::make('image')
                    ->width(150)
                    ->height(150)
                    ->disk('s3')
                    ->label(trans('admin.image')),
                Tables\Columns\TextColumn::make('description')
                    ->label(trans('admin.description')),
                Tables\Columns\TextColumn::make('notificationType.name')
                    ->sortable()
                    ->searchable()
                    ->label(trans('admin.notification_type')),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Action::make('sendNotification')
                    ->icon('heroicon-o-bell')
                    ->label('Отправить')
                    ->action(function (QuickNotification $record, array $data): void {
                        $i = 0;
                        $intervalMinute = 1;
                                $chunkMinute = 2;
                                if ($record->to_all) {
                                    config('flux-notification.models.user')::has('deviceTokens')
                                        ->selectRaw('id,name,surname,phone,email')->chunk(100, function ($users) use ($record, &$i,
                                        &$chunkMinute, $intervalMinute) {
                                        $i++;
                                        if ($i % 7 == 0) {
                                            $chunkMinute++;
                                        }
                                SendQuickNotificationJob::dispatch($users, $record)->onQueue('slow')
                                    ->delay(now()->addMinutes($intervalMinute * ( $i == 1 ? 0 : $chunkMinute)));
                            });
//                                    \Bus::dispatch(new App\Jobs\Notification\SendQuickNotificationJob(User::has('deviceTokens')->get(), QuickNotification::first()));
                        } else {
                            $record->loadMissing('users');
                            SendQuickNotificationJob::dispatch($record->users, $record)->onQueue('slow');
                        }
                        Notification::make()
                            ->title('Успешно отправлено')
                            ->success()
                            ->send();
                    })
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageQuickNotifications::route('/'),
        ];
    }
}
