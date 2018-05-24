<?php

namespace App\Notifications\Invoice;

use App\Character;
use App\Invoice;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PaymentPosted extends Notification
{
    use Queueable;

    public $transactionID;
    public $processor;
    public $amount;

    /**
     * Create a new notification instance.
     *
     * @param Character $processor
     * @param float     $amount
     * @param int       $transactionID
     * @param bool      $forced
     *
     * @return void
     */
    public function __construct(Character $processor, float $amount, int $transactionID, bool $forced = false)
    {
        $this->processor = $processor;
        $this->amount = $amount;
        $this->transactionID = $transactionID;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function via($notifiable)
    {
        return ['broadcast', 'database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param Invoice $invoice
     *
     * @return array
     */
    public function toArray($invoice)
    {
        $latestPayment = $invoice->payments()->first();
        $previousBalance = isset($latestPayment) ? $latestPayment->text['balance_due'] : $invoice->total;

        return [
            'invoice_id'       => $invoice->id,
            'previous_balance' => $previousBalance,
            'balance_due'      => $previousBalance - $this->amount,
            'amount'           => $this->amount,
            'transaction_id'   => $this->transactionID,
            'processor_id'     => $this->processor->id,
            'processor_name'   => $this->processor->name,
        ];
    }
}
