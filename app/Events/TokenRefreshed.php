<?php

namespace App\Events;

use App\Character;
use App\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class TokenRefreshed implements ShouldBroadcast
{
    use SerializesModels;

    protected $user;
    protected $character;

    /**
     * Create a new event instance.
     *
     * @param Character $character
     *
     * @return void
     */
    public function __construct(Character $character)
    {
        $this->character = $character;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('user.'.$this->character->user->id);
    }

    /**
     * Get the data to broadcast.
     *
     * @return array
     */
    public function broadcastWith()
    {
        return [
            'character' => $this->character,
            'token'     => $this->character->token,
        ];
    }
}
