<?php

namespace App\Notifications\Fleet;

use App\Fleet;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class Created extends Notification implements ShouldQueue
{
    use Queueable;

    public $fleet;

    /**
     * Create a new notification instance.
     *
     * @param Fleet $fleet
     *
     * @return void
     */
    public function __construct(Fleet $fleet)
    {
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
                    ->line("A new fleet has been scheduled for {$this->fleet->organization->name}.")
                    ->action('View Fleet', url('/fleets/'.$this->fleet->id));
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
            'fleet_id'          => $this->fleet->id,
            'fleet_name'        => $this->fleet->title,
            'organization_id'   => $this->fleet->organization_id,
            'organization_type' => $this->fleet->organization_type,
            'organization_name' => $this->fleet->organization->name,
        ];
    }
}
