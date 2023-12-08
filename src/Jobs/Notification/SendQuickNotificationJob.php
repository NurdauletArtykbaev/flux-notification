<?php

namespace Raim\FluxNotify\Jobs\Notification;

use Raim\FluxNotify\Models\QuickNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use Raim\FluxNotify\Models\User;

class SendQuickNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $users;
    protected $notification;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($users, QuickNotification $notification)
    {
        $this->users = $users;
        $this->notification = $notification;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->users as $user) {
            $this->sendNotification($user);
        }
    }

    public function sendNotification(User $user)
    {
        if ($user->isPushEnabled()) {
            return $this->notification->toPush(notifiable: $user,data: ['subject' => $this->notification->subject,'text' => $this->notification->text,
                'image' => $this->notification?->image ? env('AWS_URL') .'/'. $this->notification->image : null])->send();
        }
        return false;
    }
}
