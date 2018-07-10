<?php

namespace App\Notifications\Invoice;

use App\Invoice;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class StatusUpdatedIssuer extends Notification implements ShouldQueue
{
    use Queueable;

    public $invoice;

    public $previousStatus;

    /**
     * Create a new notification instance.
     *
     * @param Invoice $invoice
     * @param string  $previousStatus
     *
     * @return void
     */
    public function __construct(Invoice $invoice, string $previousStatus)
    {
        $this->invoice = $invoice;
        $this->previousStatus = $previousStatus;
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
        if (isset($notifiable->email)) {
            return ['mail'];
        }

        return ['database', 'broadcast'];
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
            ->subject('Issued Invoice Status Updated')
            ->line("An invoice issued by {$this->invoice->issuer->name} to {$this->invoice->recipient->name}")
            ->line("has transitioned from {$this->previousStatus} to {$this->invoice->status}.")
            ->action('View invoice', url('/invoices/'.$this->invoice->id));
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
            'invoice_id'      => $this->invoice->id,
            'issuer_name'     => $this->invoice->issuer->name,
            'recipient_name'  => $this->invoice->recipient->name,
            'previous_status' => $this->previousStatus,
            'new_status'      => $this->invoice->status,
        ];
    }
}
