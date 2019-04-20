<?php

namespace App\Events;

use App\Comment;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

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
        // get resource name of the commentable
        $commentable = json_api()->getDefaultResolver()->getResourceType($this->comment->commentable_type);

        return [
            new PrivateChannel("/{$commentable}/{$this->comment->commentable_id}"),
            new PrivateChannel("/comments/{$this->comment->id}"),
        ];
    }
}
