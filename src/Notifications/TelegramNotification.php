<?php

namespace Raim\FluxNotify\Notifications;

use Raim\FluxNotify\Helpers\DeviceTokenHelper;
use Raim\FluxNotify\Helpers\OrderHelper;
use DefStudio\Telegraph\Models\TelegraphBot;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class TelegramNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */

    public function __construct()
    {
    }

    public function via($notifiable)
    {
        $this->toTelegram($notifiable);
    }

    public function toTelegram($notifiable)
    {
        $notifiable->load(['user', 'ad']);
        if ($notifiable->status == OrderHelper::STATUS_CANCELED) {
            $message = "\nЗаказ: №" . $notifiable->id . ' отменен';
        } else {
            $platform = DeviceTokenHelper::getPlatformByNumber($notifiable->platform);
            $companyName =  $notifiable->ad?->user?->company_name ?? ($notifiable->ad?->user?->name. ' ' . $notifiable->ad?->user?->surname);
            $message = "\nЗаказ: №" . $notifiable->id
                . "\nАрендатор: " . $notifiable->user?->surname . ' ' . $notifiable->user?->name . '|' . $notifiable->user->phone
                . "\nТовар: " . $notifiable->ad?->name
                . "\nАрендодатель: " . $companyName . '|' . $notifiable->ad?->user->phone
                . "\nПлатформа: " . $platform
                . "\nГород: " . $notifiable->city?->name . "\n";
        }
        $bot = TelegraphBot::first();

        foreach ($bot->chats as $chat) {
            if ($chat->chat_id == '-1001930510896') {
                $chat->markdown($message)
                    ->reply(7)
                    ->send();
                continue;
            }
            $chat->markdown($message)->send();
        }
    }

}
