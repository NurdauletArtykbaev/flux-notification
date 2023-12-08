<?php

namespace Raim\FluxNotify\Models;

use Raim\FluxNotify\Traits\Pushable;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\QuickNotification
 *
 * @property int $id
 * @property string|null $description
 * @property array $subject
 * @property array $text
 * @property int $send_sms
 * @property int $to_all
 * @property array|null $cities
 * @property int|null $notification_type_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $full_img_src
 * @property-read mixed $img_src
 * @property-read array $translations
 * @property-read \Raim\FluxNotify\Models\NotificationType|null $notificationType
 * @method static \Illuminate\Database\Eloquent\Builder|QuickNotification newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|QuickNotification newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|QuickNotification query()
 * @method static \Illuminate\Database\Eloquent\Builder|QuickNotification whereCities($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuickNotification whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuickNotification whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuickNotification whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuickNotification whereNotificationTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuickNotification whereSendSms($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuickNotification whereSubject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuickNotification whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuickNotification whereToAll($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuickNotification whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\Raim\FluxNotify\Models\SentPushNotification[] $sentPushNotifications
 * @property-read int|null $sent_push_notifications_count
 */
class QuickNotification extends Model
{
    use Pushable;

    public const STATUS_DRAFT = 0;
    public const STATUS_SENT = 1;

    public $translatable = ['subject', 'text'];

    protected $fillable = [
        'text',
        'subject',
        'send_sms',
        'to_all',
        'description',
        'status',
        'notification_type_id',
        'image'
    ];


    public function notificationType()
    {
        return $this->belongsTo(NotificationType::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'quick_notification_user');
    }
}
