<?php

namespace App\Events;

use App\Character;
use App\Invoice;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class InvoiceUpdated implements ShouldBroadcast
{
    use SerializesModels, InteractsWithSockets;

    public $invoice;

    /**
     * Create a new event instance.
     *
     * @param Invoice $invoice
     *
     * @return void
     */
    public function __construct(Invoice $invoice)
    {
        $this->invoice = $invoice;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        $type = $this->invoice->recipient_type === Character::class ? 'characters' : 'organizations';
        $extra = ($this->invoice->recipient_type === Character::class ? '' : '/received-invoices');

        return new PrivateChannel("/{$type}/{$this->invoice->recipient_id}".$extra);
    }
}
