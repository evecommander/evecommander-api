<?php

namespace App\Events;

use App\Character;
use App\Invoice;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class InvoiceReceived implements ShouldBroadcast
{
    use SerializesModels, InteractsWithSockets;

    public $invoice;

    /**
     * Create a new event instance.
     *
     * @param Invoice $invoice
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
        $type = implode('.', explode('\\', $this->invoice->recipient_type));
        $channelName = "{$type}.{$this->invoice->recipient_id}".
            ($this->invoice->recipient_type !== Character::class ? '.Invoices' : '');

        return new PrivateChannel($channelName);
    }
}