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
use Illuminate\Support\Facades\Log;

class NotifyJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $key;
    protected $data;
    protected $user_id;
    protected $replace;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($userId, $key, $data = [], $replace = [])
    {
        $this->onQueue('notification');
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

        $user = User::findOrFail($this->user_id);
        $push = EloquentNotification::findByKey($this->key);
        Log::channel('dev')->info('$push?->id'.json_encode($push));
        if (isset($push?->id)) {
            $push->toPush($user, data: $this->data, replace: $this->replace)->send();
        }

    }
}
