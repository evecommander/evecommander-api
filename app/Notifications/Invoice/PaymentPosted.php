<?php

namespace App\Notifications\Invoice;

use App\Invoice;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class PaymentPosted extends Notification implements ShouldQueue
{
    use Queueable;

    public $transactionID;
    public $invoice;
    public $amount;
    public $forced;

    /**
     * Create a new notification instance.
     *
     * @param Invoice $invoice
     * @param float   $amount
     * @param int     $transactionID
     * @param bool    $forced
     *
     * @return void
     */
    public function __construct(Invoice $invoice, float $amount, int $transactionID, bool $forced = false)
    {
        $this->invoice = $invoice;
        $this->amount = $amount;
        $this->transactionID = $transactionID;
        $this->forced = $forced;
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
     * @param mixed $notifiable
     *
     * @return array
     */
    public function toArray($notifiable)
    {
        $latestPayment = $this->invoice->payments()->first();
        $previousBalance = isset($latestPayment) ? $latestPayment->data['balance_due'] : $this->invoice->total;

        return [
            'invoice_id'       => $this->invoice->id,
            'previous_balance' => $previousBalance,
            'balance_due'      => $previousBalance - $this->amount,
            'amount'           => $this->amount,
            'forced'           => $this->forced,
            'transaction_id'   => $this->transactionID,
        ];
    }
}
