<?php

namespace App\Notifications\Invoice;

use App\Invoice;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class Issued extends Notification implements ShouldQueue
{
    use Queueable;

    public $invoice;

    /**
     * Create a new notification instance.
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
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function via($notifiable)
    {
        $channels = ['broadcast', 'database'];

        if (isset($notifiable->email)) {
            $channels[] = 'mail';
        }

        return $channels;
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage())
                    ->line("You have received a new invoice for {$this->invoice->recipient->name}")
                    ->line("titled {$this->invoice->title}")
                    ->action('View Invoice', url('/invoices/'.$this->invoice->id));
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
        return [
            'invoice_id'     => $this->invoice->id,
            'invoice_name'   => $this->invoice->title,
            'issuer_name'    => $this->invoice->issuer->name,
            'issuer_id'      => $this->invoice->issuer_id,
            'issuer_type'    => $this->invoice->issuer_type,
            'recipient_name' => $this->invoice->recipient->name,
            'recipient_id'   => $this->invoice->recipient_id,
            'recipient_type' => $this->invoice->recipient_type,
            'amount'         => $this->invoice->total,
            'due'            => $this->invoice->due_date,
        ];
    }
}
