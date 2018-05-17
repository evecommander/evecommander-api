<?php

namespace App\Listeners;

use Illuminate\Notifications\Events\NotificationSent;

class BubbleNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param NotificationSent $event
     *
     * @return void
     */
    public function handle(NotificationSent $event)
    {
        // if the notification is meant to be bubbled, do it
        if (method_exists($event->notifiable, 'bubbleNotification')) {
            $event->notifiable->bubbleNotification($event);
        }
    }
}
