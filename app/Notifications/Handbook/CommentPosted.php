<?php

namespace App\Notifications\Handbook;

use App\Comment;
use App\Handbook;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CommentPosted extends Notification implements ShouldQueue
{
    use Queueable;

    public $handbook;
    public $comment;

    /**
     * Create a new notification instance.
     *
     * @param Handbook $handbook
     * @param Comment  $comment
     *
     * @return void
     */
    public function __construct(Handbook $handbook, Comment $comment)
    {
        $this->handbook = $handbook;
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
                    ->line("{$this->comment->character->name} posted a new comment on the {$this->handbook->title} handbook.")
                    ->action('View Handbook', url('/handbooks/'.$this->handbook->id));
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
            'handbook_id'   => $this->handbook->id,
            'handbook_name' => $this->handbook->title,
            'author_id'     => $this->comment->character_id,
            'author_name'   => $this->comment->character->name,
            'comment_text'  => $this->comment->text,
        ];
    }
}
