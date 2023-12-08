<?php

namespace Raim\FluxNotify\Jobs\Notification;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Raim\FluxNotify\Models\User;
use Raim\FluxNotify\Models\Order;
use Raim\FluxNotify\Models\Notification as EloquentNotification;

class NotifyAboutOrderJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $order;
    protected $key;
    protected $data;
    protected $user_id;
    protected $replace;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($order, $key, $data = [], $replace = [], $userId = null)
    {
        $this->onQueue('notification');
        $this->order = $order;
        $this->key = $key;
        $this->replace = $replace;
        $this->user_id = $userId;
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $user = User::findOrFail($this->user_id ?? $this->order->user_id);
        $push = EloquentNotification::findByKey($this->key);

        if (isset($push?->id)) {
            $this->data = array_merge($this->data, ['order_id' => $this->order->id]);

            $push->toPush($user, data:$this->data, replace: $this->replace )->send();
        }
    }
}
