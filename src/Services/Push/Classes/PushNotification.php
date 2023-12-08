<?php

namespace Raim\FluxNotify\Push\Classes;

use Raim\FluxNotify\Helpers\DeviceTokenHelper;
use Raim\FluxNotify\Helpers\NotificationHelper;
use Raim\FluxNotify\Models\SentPushNotification;
use Raim\FluxNotify\Facades\PushFacade;
use App\Repositories\v1\DeviceTokenRepository;
use Raim\FluxNotify\Push\Jobs\SendPushNotificationJob;

class PushNotification
{
    private $pushable;
    private mixed $receiver;
    private array $push;
    private array $data;
    private $text;

    public function __construct($pushable, $notifiable = null, $data = [], $replace = [])
    {
        $this->pushable = $pushable;
        $this->receiver = $notifiable;
        $this->data = $data;
        $this->text = $this->applyReplacement($data['text'] ?? $this->pushable?->text, $replace);
        $this->push = $this->preparePushData($data, $replace);
    }

    private function preparePushData($data, $replace = []): array
    {
        $body = [
            'subject' => $this->applyReplacement($data['subject'] ?? $this->pushable?->subject ?? 'Naprocat', $replace),
            'text' => $this->applyReplacement($data['text'] ?? $this->pushable?->text, $replace),
            "sound" => "default",
            'extra' => [
                'image' => $this->pushable?->image ? (env('AWS_URL') . '/' . $this->pushable->image) : null
            ]
        ];
        if (isset($data['order_id']) && $data['order_id']) {
            $body['extra']['order_id'] = (int)$data['order_id'];
        }
        if (isset($data['user_id']) && $data['user_id']) {
            $body['extra']['user_id'] = (int)$data['user_id'];
        }
        if (isset($data['lord_id']) && $data['lord_id']) {
            $body['extra']['lord_id'] = (int)$data['lord_id'];
        }
        $body['extra']['type'] = $this->pushable->notificationType?->slug;
        return $body;
    }

    public function send()
    {
        return match (config('services.push.connection')) {
            'sync' => PushFacade::notify($this),
            'queue' => SendPushNotificationJob::dispatch($this)->onQueue('notification'),
        };
    }

    public function getReceiver()
    {
        return $this->receiver;
    }

    public function __get($attribute)
    {
        return $this->push[$attribute] ?? null;
    }

    public function handleResponse($responseData): bool
    {
        [$response, $driver] = $responseData;
        $status = $this->getStatus($response, $driver);

        $data = $this->prepareData($response, $status);

        if (isset($data['fields_json']['order_id'])) {
            SentPushNotification::whereUserId($this->receiver->id,)
                ->whereJsonContains('fields_json->order_id', $this->data['order_id'])
                ->where('is_old_notification', false)
                ->update([
                    'is_old_notification' => true
                ]);
        }
        $this->pushable->sentPushNotifications()->create($data);
        return $status && $status === 'ok';
    }

    private function getStatus($response, $driver)
    {
        $status = NotificationHelper::STATUS_UNREAD;
        if ($driver == DeviceTokenHelper::DRIVER_EXPO) {

            if (empty($response) || !isset($response['data']) || !isset($response['data'][0])) {
                (new DeviceTokenRepository())->deleteUserTokens($this->receiver, $driver);
                return $status;
            }

            $status = $response['data'][0]['status'] ?? null;
            if ($status && $status === 'ok') {
                $status = NotificationHelper::STATUS_UNREAD;
            } else {
                (new DeviceTokenRepository())->deleteUserTokens($this->receiver, $driver);
                $status = NotificationHelper::STATUS_FAILED;
            }
        }
        return $status;
    }

    private function prepareData($response, $status)
    {
        $data = [
            'status' => $status,
            'user_id' => $this->receiver->id,
            'fields_json' => $response['data'] ?? ($response['data'][0] ?? []),
        ];

        if ($this->text) {
            $data['fields_json']['text'] = $this->text;
        }
        if (isset($this->data['ad'])) {
            $data['fields_json']['ad']['id'] = $this->data['ad']['id'] ?? null;
            $data['fields_json']['ad']['name'] = $this->data['ad']['name'] ?? null;
            $data['fields_json']['ad']['image'] = $this->data['ad']['image'] ?? null;
            $data['fields_json']['ad']['last_image'] = $this->data['ad']['last_image'] ?? null;
        }

        if (isset($this->data['order_id'])) {
            $data['fields_json']['order_id'] = $this->data['order_id'] ?? null;
        }

        if (isset($this->data['user_id'])) {
            $data['fields_json']['user_id'] = $this->data['user_id'] ?? null;
        }
        if (isset($this->data['lord_id'])) {
            $data['fields_json']['lord_id'] = $this->data['lord_id'] ?? null;
        }

        if (isset($this->data['image']) && $this->data['image']) {
            $data['fields_json']['image'] = $this->data['image'] ?? null;
        }

        if ($this->push['subject']) {
            $data['fields_json']['subject'] = $this->push['subject'];
        }
//        if ($this->push['extra']) {
//            $data['fields_json']['subject'] = $this->push['subject'];
//        }


        if ($status == NotificationHelper::STATUS_UNREAD) {
            $data['token_id'] = $response['data'] ?? ($response['data'][0]['id'] ?? null);
        }

        $data['notification_type_id'] = $this->pushable?->notification_type_id ?? null;
        if (isset($this->data['order_id'])) {
            $data['fields_json']['order_id'] = $this->data['order_id'] ?? null;
        }
        return $data;
    }

    private function applyReplacement(string $str, array $replace = []): string
    {
        return str_replace(
            array_map(function ($key) {
                return "{{$key}}";
            }, array_keys($replace)),
            array_values($replace),
            $str
        );
    }
}
