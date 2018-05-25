<?php

namespace App\Notifications\Membership;

use App\Membership;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class Updated extends Notification implements ShouldQueue
{
    use Queueable;

    public $membership;

    /**
     * Create a new notification instance.
     *
     * @param Membership $membership
     *
     * @return void
     */
    public function __construct(Membership $membership)
    {
        $this->membership = $membership;
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
                    ->line("The membership between {$this->membership->member->first()->name}")
                    ->line("and {$this->membership->organization->first()->name} has been updated.")
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
            'member_name'       => $this->membership->member->first()->name,
            'organization_id'   => $this->membership->organization_id,
            'organization_type' => $this->membership->organization_type,
            'organization_name' => $this->membership->organization->first()->name,
        ];
    }
}
