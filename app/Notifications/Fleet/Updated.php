<?php

namespace App\Notifications\Fleet;

use App\Character;
use App\Fleet;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class Updated extends Notification implements ShouldQueue
{
    use Queueable;

    public $fleet;

    /**
     * Create a new notification instance.
     *
     * @param Fleet     $fleet
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
        return ['mail'];
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
            ->subject('Fleet Updated')
            ->line("{$this->fleet->lastUpdatedBy->name} has updated the {$this->fleet->title} fleet.")
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
        return [];
    }
}
