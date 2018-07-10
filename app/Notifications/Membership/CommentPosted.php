<?php

namespace App\Notifications\Membership;

use App\Comment;
use App\Membership;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CommentPosted extends Notification implements ShouldQueue
{
    use Queueable;

    public $membership;
    public $comment;

    /**
     * Create a new notification instance.
     *
     * @param Membership $membership
     * @param Comment    $comment
     *
     * @return void
     */
    public function __construct(Membership $membership, Comment $comment)
    {
        $this->membership = $membership;
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
            ->subject('Comment Posted')
            ->line("{$this->comment->character->name} posted a comment on a membership between")
            ->line("{$this->membership->member->name} and {$this->membership->organization->name}")
            ->action('View Membership', url('/memberships/'.$this->membership->id));
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
            'membership_id'     => $this->membership->id,
            'member_id'         => $this->membership->member_id,
            'member_type'       => $this->membership->member_type,
            'member_name'       => $this->membership->member->name,
            'organization_id'   => $this->membership->organization_id,
            'organization_type' => $this->membership->organization_type,
            'organization_name' => $this->membership->organization->name,
            'author_id'         => $this->comment->character_id,
            'author_name'       => $this->comment->character->name,
            'comment_text'      => $this->comment->text,
        ];
    }
}
