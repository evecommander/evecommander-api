<?php

namespace App\Events;

use App\Fleet;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class FleetUpdated implements ShouldBroadcast
{
    use SerializesModels, InteractsWithSockets;

    public $fleet;

    /**
     * Create a new event instance.
     *
     * @param Fleet $fleet
     *
     * @return void
     */
    public function __construct(Fleet $fleet)
    {
        $this->fleet = $fleet;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('/fleets/'.$this->fleet->id);
    }
}
