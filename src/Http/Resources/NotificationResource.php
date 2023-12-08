<?php

namespace Raim\FluxNotify\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        if (isset($this->fields_json['ad'])) {
            $ad = [
                'id' => $this->fields_json['ad']['id'],
                'name' => $this->fields_json['ad']['name'],
                'image' => $this->fields_json['ad']['image'],
                'last_image' => $this->fields_json['ad']['last_image'],
            ];
        }

        return [
            'id' => $this->id,
            'token_id' => $this->token_id,
            'subject' => $this->fields_json['subject'] ?? $this->removeVariablesFromText($this->pushable->subject),
            'text' => $this->fields_json['text'] ?? $this->removeVariablesFromText($this->pushable->text),
            'order_id' => $this->fields_json['order_id'] ?? null,
            'ad' => $ad ?? null,
            'notification_type_id' => $this->notification_type_id,
            'order' => $this->whenLoaded('order', function () {
                return [
                    'id' => $this->order->id,
                    'client_status' => $this->order->client_status,
                    'lord_status' => $this->order->lord_status,
                    'status' => $this->order->status,
                ];
            }),
            'status' => $this->status,
            'created_at' => $this->created_at?->format('Y-m-d  H:i') ?? null,
        ];
    }

    private function removeVariablesFromText($text)
    {
        $pattern = '/{(\w+)}/';
        $replacement = '';
        $text = preg_replace($pattern, $replacement, $text);
        $text = preg_replace('/№/', '', $text);
        return preg_replace('!\s++!u', ' ', $text);
    }
}
