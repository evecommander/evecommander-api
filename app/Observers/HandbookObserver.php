<?php

namespace App\Observers;

use App\Character;
use App\Events\HandbookCreated;
use App\Events\HandbookDeleted;
use App\Events\HandbookUpdated;
use App\Handbook;
use App\Http\Middleware\CheckCharacter;
use App\Notifications\Handbook\Created;
use App\Notifications\Handbook\Updated;
use App\Subscription;
use Illuminate\Support\Facades\Notification;

class HandbookObserver
{
    /**
     * Handle to the handbook "creating" event.
     *
     * @param \App\Handbook $handbook
     *
     * @return void
     */
    public function creating(Handbook $handbook)
    {
        /** @var Character $character */
        $character = Character::find(request()->header(CheckCharacter::CHARACTER_HEADER));

        $handbook->createdBy()->associate($character);
    }

    /**
     * Handle to the handbook "created" event.
     *
     * @param \App\Handbook $handbook
     *
     * @return void
     */
    public function created(Handbook $handbook)
    {
        $subscriptions = $handbook->organization
            ->subscriptions()
            ->where('subscriptions.notification', '=', array_search(Created::class, Subscription::AVAILABLE_NOTIFICATIONS))
            ->with('character.user')
            ->get();

        $notifiables = $subscriptions->map(function (Subscription $subscription) use ($handbook) {
            return $subscription->character->user;
        });

        Notification::send($notifiables, new Created($handbook));
        broadcast(new HandbookCreated($handbook));
    }

    /**
     * Handle the handbook "updating" event.
     *
     * @param \App\Handbook $handbook
     *
     * @return void
     */
    public function updating(Handbook $handbook)
    {
        /** @var Character $character */
        $character = Character::find(request()->header(CheckCharacter::CHARACTER_HEADER));

        $handbook->lastUpdatedBy()->associate($character);
    }

    /**
     * Handle to the handbook "updated" event.
     *
     * @param Handbook $handbook
     *
     * @return void
     */
    public function updated(Handbook $handbook)
    {
        $subscriptions = $handbook->organization
            ->subscriptions()
            ->where('subscriptions.notification', '=', array_search(Updated::class, Subscription::AVAILABLE_NOTIFICATIONS))
            ->with('character.user')
            ->get();

        $notifiables = $subscriptions->map(function (Subscription $subscription) use ($handbook) {
            return $subscription->character->user;
        });

        Notification::send($notifiables, new Updated($handbook));

        broadcast(new HandbookUpdated($handbook));
    }

    /**
     * Handle the handbook "deleted" event.
     *
     * @param \App\Handbook $handbook
     *
     * @return void
     */
    public function deleted(Handbook $handbook)
    {
        broadcast(new HandbookDeleted($handbook));
    }
}
