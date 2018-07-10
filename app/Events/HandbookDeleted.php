<?php

namespace App\Events;

use App\Handbook;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class HandbookDeleted implements ShouldBroadcast
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
        $type = end(explode('\\', $this->handbook->organization_type));

        return new PrivateChannel("App.{$type}.{$this->handbook->organization_id}.Handbooks");
    }
}
