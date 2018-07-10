<?php

namespace App\Events;

use App\Handbook;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class HandbookUpdated implements ShouldBroadcast
{
    use SerializesModels, InteractsWithSockets;

    public $handbook;

    /**
     * Create a new event instance.
     *
     * @param Handbook $handbook
     *
     * @return void
     */
    public function __construct(Handbook $handbook)
    {
        $this->handbook = $handbook;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel("App.Handbook.{$this->handbook->id}");
    }
}
