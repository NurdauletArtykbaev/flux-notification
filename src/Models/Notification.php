<?php

namespace Raim\FluxNotify\Models;

use Raim\FluxNotify\Traits\Pushable;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Notification
 *
 * @property int $id
 * @property string $key
 * @property string|null $description
 * @property array $subject
 * @property array $text
 * @property int $send_sms
 * @property int|null $notification_type_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read array $translations
 * @method static \Illuminate\Database\Eloquent\Builder|Notification newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Notification newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Notification query()
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereNotificationTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereSendSms($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereSubject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read SentPushNotification[] $sentPushNotifications
 * @property-read int|null $sent_push_notifications_count
 */
class Notification extends Model
{
    use Pushable;

    public $translatable = ['text', 'subject'];

    protected $fillable = [
        'text',
        'subject',
        'description',
        'send_sms',
        'key',
        'notification_type_id'
    ];

    //SCOPES
    public function scopeFindByKey($query, string $key)
    {
        return $query->where('key', $key)->first();
    }

    public function notificationType() {
        return $this->belongsTo(NotificationType::class,'notification_type_id','id');
    }
}
