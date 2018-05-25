<?php

namespace App\Notifications\Handbook;

use App\Character;
use App\Handbook;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class Updated extends Notification implements ShouldQueue
{
    use Queueable;

    public $handbook;
    public $editor;

    /**
     * Create a new notification instance.
     *
     * @param Handbook  $handbook
     * @param Character $editor
     *
     * @return void
     */
    public function __construct(Handbook $handbook, Character $editor)
    {
        $this->handbook = $handbook;
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
                    ->line("{$this->editor->name} has updated the {$this->handbook->title}.")
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
            'editor_id'     => $this->editor->id,
            'editor_name'   => $this->editor->name,
        ];
    }
}
