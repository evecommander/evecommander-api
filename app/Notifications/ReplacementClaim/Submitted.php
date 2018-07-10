<?php

namespace App\Notifications\ReplacementClaim;

use App\ReplacementClaim;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class Submitted extends Notification implements ShouldQueue
{
    use Queueable;

    public $claim;

    /**
     * Create a new notification instance.
     *
     * @param ReplacementClaim $claim
     *
     * @return void
     */
    public function __construct(ReplacementClaim $claim)
    {
        $this->claim = $claim;
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
            ->subject('Replacement Claim Submitted')
            ->line("A new replacement claim has been filed by {$this->claim->character->name}")
            ->line("against {$this->claim->organization->name}")
            ->action('View Claim', url('/replacement-claims/'.$this->claim->id));
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
            'claim_id'          => $this->claim->id,
            'character_id'      => $this->claim->character_id,
            'character_name'    => $this->claim->character->name,
            'organization_id'   => $this->claim->organization_id,
            'organization_type' => $this->claim->organization_type,
            'organization_name' => $this->claim->organization->name,
        ];
    }
}
