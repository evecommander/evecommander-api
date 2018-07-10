<?php

namespace App\Events;

use App\Handbook;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class HandbookUpdated implements ShouldBroadcast
{
    use SerializesModels, InteractsWithSockets;

    public $handbook;

    /**
     * Create a new event instance.
     *
     * @param Handbook $handbook
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