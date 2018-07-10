<?php

namespace App\Events;

use App\Comment;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class CommentAdded implements ShouldBroadcast
{
    use SerializesModels, InteractsWithSockets;

    public $comment;

    /**
     * Create a new event instance.
     *
     * @param Comment $comment
     *
     * @return void
     */
    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        $type = implode('.', explode('\\', $this->comment->commentable_type));

        return new PrivateChannel("{$type}.{$this->comment->commentable_id}");
    }
}
