<?php

namespace App\Notifications\Invoice;

use App\Character;
use App\Comment;
use App\Invoice;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CommentPosted extends Notification implements ShouldQueue
{
    use Queueable;

    public $invoice;
    public $comment;

    /**
     * Create a new notification instance.
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
                    ->line('A new comment has been posted on your invoice by '.$this->comment->character->name.'.')
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
        /** @var Character $author */
        $author = $this->comment->character;

        return [
            'invoice_id'   => $this->invoice->id,
            'invoice_name' => $this->invoice->title,
            'author_id'    => $author->id,
            'author_name'  => $author->name,
            'comment_text' => $this->comment->text,
        ];
    }
}
