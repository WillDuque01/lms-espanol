<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Broadcast;

class BroadcastInAppNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public int $userId, public array $payload)
    {
    }

    public function handle(): void
    {
        Broadcast::channel('private-users.'.$this->userId, function(){ return true; });
        broadcast(new \Illuminate\Notifications\Events\BroadcastNotificationCreated((object) [
            'id' => uniqid('evt_'),
            'type' => 'inapp',
            'data' => $this->payload,
            'notifiable_id' => $this->userId,
            'notifiable_type' => 'user',
        ]));
    }
}


