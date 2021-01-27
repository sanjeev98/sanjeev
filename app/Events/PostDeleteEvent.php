<?php

namespace App\Events;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PostDeleteEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $postDelete;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($postDelete)
    {
        $this->postDelete = $postDelete;
    }
}
