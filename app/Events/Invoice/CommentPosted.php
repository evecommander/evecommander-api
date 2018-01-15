<?php

namespace App\Events\Invoice;


use App\Comment;
use App\Invoice;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CommentPosted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $invoice;

    public $comment;

    /**
     * Create a new event instance.
     *
     * @param Invoice $invoice
     * @param Comment $comment
     *
     * @return void
     */
    public function __construct(Invoice $invoice, Comment $comment)
    {
        $this->invoice = $invoice;
        $this->comment = $comment;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}