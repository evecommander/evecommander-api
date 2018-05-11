<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Notifications\Events\NotificationSent;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;

trait BubblesNotifications
{
    public $bubbleToRelation = null;

    /**
     * Get the models to bubble notifications to
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    protected function getBubbleToModels(Notification $notification)
    {
        if (!isset($this->bubbleToRelation)) {
            return new Collection();
        }

        /** @var Relation $related */
        $related = $this->{$this->bubbleToRelation}();

        return $related->get();
    }

    /**
     * Bubble the given notification to the defined models
     *
     * @param NotificationSent $notificationSent
     */
    public function bubbleNotification(NotificationSent $notificationSent)
    {
        $models = $this->getBubbleToModels($notificationSent->notification);

        /** @var Notifiable $model */
        foreach ($models as $model) {
            // check for the presence of the Notifiable trait
            if (method_exists($model, 'notify')) {
                $model->notify($notificationSent->notification);
            }
        }
    }
}