<?php

namespace App\Notifications\Membership;

use App\Abstracts\Organization;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class MembersUpdated extends Notification implements ShouldQueue
{
    use Queueable;

    protected $organization;
    protected $added;
    protected $removed;

    /**
     * Create a new notification instance.
     *
     * @param Organization $organization
     * @param array        $added
     * @param array        $removed
     *
     * @return void
     */
    public function __construct(Organization $organization, array $added, array $removed)
    {
        $this->organization = $organization;
        $this->added = $added;
        $this->removed = $removed;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
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
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        if (count($this->added) > count($this->removed)) {
            $mapped = collect($this->added)->map(function ($item, $index) {
                $temp = ['added' => $item];

                if (isset($this->removed[$index])) {
                    $temp['removed'] = $this->removed[$index];
                }

                return $temp;
            });
        } else {
            $mapped = collect($this->removed)->map(function ($item, $index) {
                $temp = ['removed' => $item];

                if (isset($this->added[$index])) {
                    $temp['added'] = $this->added[$index];
                }

                return $temp;
            });
        }

        $organizationType = end(explode('\\', get_class($this->organization)));

        return (new MailMessage)->markdown('mail.members-updated', [
            'organization'      => $this->organization,
            'organization_type' => $organizationType,
            'changed'           => $mapped,
        ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        $callback = function ($item) {
            return [
                'id'   => $item->id,
                'type' => get_class($item),
                'name' => $item->name,
            ];
        };

        return [
            'organization_id'   => $this->organization->id,
            'organization_type' => get_class($this->organization),
            'organization_name' => $this->organization->name,
            'added'             => collect($this->added)->map($callback),
            'removed'           => collect($this->removed)->map($callback),
        ];
    }
}
