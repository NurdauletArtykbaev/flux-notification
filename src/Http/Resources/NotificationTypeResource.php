<?php

namespace Raim\FluxNotify\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NotificationTypeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
//            'count' => $this->name,
            'count'  => $this->sent_push_notifications_count ?? null,
            'message' => $this->whenLoaded('sentPushNotifications', function () {
                if (!$this->sentPushNotifications->count()) {
                    return null;
                }
                return [
                    'text' => $this->sentPushNotifications->first()?->fields_json['text'],
                    'subject' => $this->sentPushNotifications->first()?->fields_json['subject']
                ];
            }),
            'slug' => $this->slug,
        ];
    }
}
