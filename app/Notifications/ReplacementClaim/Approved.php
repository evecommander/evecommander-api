<?php

namespace App\Notifications\ReplacementClaim;

use App\Character;
use App\ReplacementClaim;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class Approved extends Notification implements ShouldQueue
{
    use Queueable;

    public $claim;
    public $approver;

    /**
     * Create a new notification instance.
     *
     * @param ReplacementClaim $claim
     * @param Character $approver
     *
     * @return void
     */
    public function __construct(ReplacementClaim $claim, Character $approver)
    {
        $this->claim = $claim;
        $this->approver = $approver;
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
                    ->line("The SRP claim you filed with {$this->claim->organization->first()->name} was approved")
                    ->line("by {$this->approver->name}")
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
            'approver_id'       => $this->approver->id,
            'organization_id'   => $this->claim->organization_id,
            'organization_type' => $this->claim->organization_type,
            'organization_name' => $this->claim->organization->first()->name,
        ];
    }
}
