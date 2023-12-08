<?php

namespace Raim\FluxNotify\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

/**
 * App\Models\NotificationType
 *
 * @property int $id
 * @property array $name
 * @property string $slug
 * @property int|null $parent_id
 * @property int $lft
 * @property int $rgt
 * @property int $depth
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $full_img_src
 * @property-read mixed $img_src
 * @property-read array $translations
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationType query()
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationType whereDepth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationType whereLft($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationType whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationType whereRgt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationType whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationType whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class NotificationType extends Model
{

    use HasTranslations;
    public $translatable = ['name'];

    protected $fillable = [
        'name',
        'slug',
        'is_active',
    ];

    public function sentPushNotifications() {
        return $this->hasMany(SentPushNotification::class);
    }

    public function scopeIsActive($query) {
        return $query->where('is_active', 1);
    }

    protected $casts = [
        'is_active' => 'boolean'
    ];
}
