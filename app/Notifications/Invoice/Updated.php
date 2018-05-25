<?php

namespace App\Notifications\Invoice;

use App\Character;
use App\Invoice;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class Updated extends Notification implements ShouldQueue
{
    use Queueable;

    public $invoice;
    public $editor;

    /**
     * Create a new notification instance.
     *
     * @param Invoice   $invoice
     * @param Character $editor
     *
     * @return void
     */
    public function __construct(Invoice $invoice, Character $editor)
    {
        $this->invoice = $invoice;
        $this->editor = $editor;
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
        $channels = ['database', 'broadcast'];

        if ($notifiable->email) {
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
                    ->line("Your invoice {$this->invoice->title} has been updated by {$this->editor->name}.")
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
            'invoice_id'   => $this->invoice->id,
            'invoice_name' => $this->invoice->title,
            'editor_id'    => $this->editor->id,
            'editor_name'  => $this->editor->name,
        ];
    }
}
