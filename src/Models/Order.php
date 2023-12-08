<?php

namespace Raim\FluxNotify\Models;

use App\Helpers\OrderHelper;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Order extends Model
{
    use HasFactory, SoftDeletes, Notifiable;

    protected $table = 'orders';
    protected $guarded = ['id'];

//Принять Заказ ( у продавца)
//Заказ принят (у продовца)
//Заказ принят, (далее способ заказа) - (клиента)
//Заказ Выдан (продовец)
//Заказ выдан, (продавца и клеинта)
//__________
//Заказ "Активен"
//до срока окончание
//__________
//Заказ "Завершен"
//после окончание срока
//_________
//и все эти 2 статуса выше перечисленных подтверждается СМС - кодом
//Мурат NextIn: У нас есть 3 статуса
//1 - Новые
//до того момента пока не принят арендадателем
//2 - Активные
//после того как принято арендадателем
//3 - История
//после окончание арендного срока

    const LORD_NEW_ORDER = 0;
    const CLIENT_PROCESSING = 0;
    const LORD_ACCEPTED = 1;
    const CLIENT_ACCEPTED = 1;
    const LORD_ISSUED = 2;
    const CLIENT_RECEIVED = 2;
    const CLIENT_CANCELED = 3;
    const LORD_WANTS_BACK = 3;
    const LORD_GOT = 4;
    const LORD_CANCELED = 5;
    const CLIENT_RETURNED = 4;

    const GENERAL_NEW = 0;
    const GENERAL_ACCEPTED = 1;
    const GENERAL_ACTIVE = 2;
    const GENERAL_HISTORY = 3;
    const GENERAL_CANCELED = 4;
    const GENERAL_FINISHED = 5;

    /* CLIENT_PROCESSING, LORD_NEW_ORDER */
    //    const TEST_GENERAL_PROCESSING = 0;
    const TEST_GENERAL_NEW = 0;
    /* LORD_ACCEPTED = 1 , CLIENT_ACCEPTED = 1 */
    const TEST_GENERAL_ACCEPTED = 1;
    /* LORD_ISSUED = 2, CLIENT_RECEIVED = 2*/
    const TEST_GENERAL_ACTIVE = 2;
    /* ? * */
    const TEST_GENERAL_HISTORY = 3;
    /* client, lord cancelled */
    const TEST_GENERAL_CLIENT_CANCELED = 4;
    const TEST_GENERAL_LORD_CANCELED = 5;
    /* Order::LORD_GOT = 4, Order::CLIENT_RETURNED = 4*/
    const TEST_GENERAL_FINISHED = 6;

    protected $casts = [
        'is_used_bonus' => 'boolean',
        'is_fast_delivery' => 'boolean',
        'created_at' => 'datetime:d.m.Y H:i'
    ];

    // public function ad()
    // {
    //     return $this->belongsTo(Ad::class, 'ad_id')->withTrashed();
    // }

    public function createdAt(): Attribute
    {
        return Attribute::make(
            get: function(mixed $value, array $attributes) {
                return $attributes['created_at'] ? Carbon::create($attributes['created_at'])->addHours(6)->timezone('Asia/Almaty') : null;
            });
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // public function rentalDay()
    // {
    //     return $this->belongsTo(RentalDay::class, 'rent_id');
    // }

    // public function city()
    // {
    //     return $this->belongsTo(City::class);
    // }

    // public function store()
    // {
    //     return $this->belongsTo(Store::class);
    // }

    public function getDeliveryDateInfoAttribute()
    {
        $date = '';
        if ($this->is_fast_delivery) {
            $date = 'Быстрая доставка: ';
        }
        return $date . ' ' . $this->delivery_date . ' ' . $this->delivery_time;
    }

    // public function status(): Attribute
    // {
    //     return Attribute::make(
    //         get: function(mixed $value, array $attributes) {

    //             if ($attributes['status'] == OrderHelper::STATUS_ACTIVE) {
    //                 if ($attributes['date_to'] && Carbon::create($attributes['date_to']) < now() ) {
    //                     return OrderHelper::STATUS_EXPIRED;
    //                 }
    //             }
    //             return $attributes['status'];
    //         });
    // }

    // public function receiveMethod()
    // {
    //     return $this->belongsTo(ReceiveMethod::class, 'receive_method_id');
    // }

    // public function paymentMethod()
    // {
    //     return $this->belongsTo(PaymentMethod::class, 'payment_method_id');
    // }


}
