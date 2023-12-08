<?php

namespace Raim\FluxNotify\Models;

use Raim\FluxNotify\Models\Order;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\SentPushNotification
 *
 * @property int $id
 * @property string|null $token_id
 * @property int $user_id
 * @property string $status
 * @property string $pushable_type
 * @property int $pushable_id
 * @property int|null $notification_type_id
 * @property string|null $fields_json
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read NotificationType|null $notificationType
 * @method static \Illuminate\Database\Eloquent\Builder|SentPushNotification newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SentPushNotification newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SentPushNotification query()
 * @method static \Illuminate\Database\Eloquent\Builder|SentPushNotification whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SentPushNotification whereFieldsJson($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SentPushNotification whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SentPushNotification whereNotificationTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SentPushNotification wherePushableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SentPushNotification wherePushableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SentPushNotification whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SentPushNotification whereTokenId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SentPushNotification whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SentPushNotification whereUserId($value)
 * @mixin \Eloquent
 * @property-read Model|\Eloquent $pushable
 */
class SentPushNotification extends Model
{
    use \Staudenmeir\EloquentJsonRelations\HasJsonRelationships;
    protected $fillable = [
        'token_id',
        'user_id',
        'status',
        'pushable_id',
        'pushable_type',
        'fields_json',
        'is_old_notification',
        'notification_type_id'
    ];

    protected $casts = [
        'fields_json' => 'array',
        'is_old_notification' => 'boolean'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'fields_json->order_id');
    }

    public function pushable() {
        return $this->morphTo();
    }

    public function notificationType() {
        return $this->belongsTo(NotificationType::class);
    }

    public function scopeIsNotOld($query)
    {
        return $query->where('is_old_notification', false);
    }
}
