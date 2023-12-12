<?php

namespace Raim\FluxNotify\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;


/**
 * @property int $id
 * @property string $contract
 */
class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = ['id'];

    public function sentPushNotifications()
    {
        return $this->hasMany(SentPushNotification::class);
    }
    public function isPushEnabled()
    {

        return true;
//        return $this->deviceTokens()->exists();
    }
    public function deviceTokens()
    {
        return $this->hasMany(DeviceToken::class);
    }
}
