<?php

namespace App\Observers;

use App\Character;
use App\Events\FleetCreated;
use App\Events\FleetUpdated;
use App\Fleet;
use App\Http\Middleware\CheckCharacter;
use App\Notifications\Fleet\Created;
use App\Notifications\Fleet\Updated;
use App\Rsvp;
use App\Subscription;
use Illuminate\Support\Facades\Notification;

class FleetObserver
{
    /**
     * Handle to the fleet "creating" event.
     *
     * @param \App\Fleet $fleet
     *
     * @return void
     */
    public function creating(Fleet $fleet)
    {
        /** @var Character $character */
        $character = Character::find(request()->header(CheckCharacter::CHARACTER_HEADER));

        $fleet->createdBy()->associate($character);
    }

    /**
     * Handle to the fleet "created" event.
     *
     * @param Fleet $fleet
     *
     * @return void
     */
    public function created(Fleet $fleet)
    {
        $subscriptions = $fleet->organization
            ->subscriptions()
            ->where(
                'subscriptions.notification',
                '=',
                array_search(Created::class, Subscription::AVAILABLE_NOTIFICATIONS)
            )
            ->with('character.user')
            ->get();

        $notifiables = $subscriptions->map(function (Subscription $subscription) use ($fleet) {
            return $subscription->character->user;
        });

        Notification::send($notifiables, new Created($fleet));

        broadcast(new FleetCreated($fleet));
    }

    /**
     * Handle the fleet "updating" event.
     *
     * @param \App\Fleet $fleet
     *
     * @return void
     */
    public function updating(Fleet $fleet)
    {
        /** @var Character $character */
        $character = Character::find(request()->header(CheckCharacter::CHARACTER_HEADER));

        $fleet->lastUpdatedBy()->associate($character);
    }

    /**
     * Handle to the fleet "updated" event.
     *
     * @param Fleet $fleet
     *
     * @return void
     */
    public function updated(Fleet $fleet)
    {
        $rsvps = $fleet->rsvps()
            ->with('character.user')
            ->whereIn('response', [
                Rsvp::RESPONSE_YES,
                Rsvp::RESPONSE_MAYBE,
            ])
            ->get();

        $notifiables = $rsvps->map(function (Rsvp $rsvp) use ($fleet) {
            return $rsvp->character->user;
        });

        Notification::send($notifiables, new Updated($fleet));

        broadcast(new FleetUpdated($fleet));
    }
}
