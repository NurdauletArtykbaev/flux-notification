<?php

namespace Raim\FluxNotify\Push\Jobs;

use Raim\FluxNotify\Push\Classes\PushNotification;
use Raim\FluxNotify\Facades\PushFacade;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendPushNotificationJob
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $push;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(PushNotification $push)
    {
        $this->push = $push;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        PushFacade::notify($this->push);
    }
}
