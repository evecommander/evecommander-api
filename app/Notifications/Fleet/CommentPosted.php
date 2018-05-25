<?php

namespace App\Notifications\Fleet;

use App\Character;
use App\Comment;
use App\Fleet;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CommentPosted extends Notification implements ShouldQueue
{
    use Queueable;

    public $comment;
    public $fleet;

    /**
     * Create a new notification instance.
     *
     * @param Comment $comment
     * @param Fleet   $fleet
     *
     * @return void
     */
    public function __construct(Comment $comment, Fleet $fleet)
    {
        $this->comment = $comment;
        $this->fleet = $fleet;
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
                    ->line("A comment has been posted on the {$this->fleet->title} fleet.")
                    ->action('View Comment', url('/fleets/'.$this->fleet->id));
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
            'fleet_id'     => $this->fleet->id,
            'fleet_name'   => $this->fleet->title,
            'comment_text' => $this->comment->text,
            'author_id'    => $author->id,
            'author_name'  => $author->name,
        ];
    }
}
