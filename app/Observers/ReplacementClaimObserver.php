<?php

namespace App\Observers;

use App\Character;
use App\Http\Middleware\CheckCharacter;
use App\Notifications\ReplacementClaim\Submitted;
use App\Notifications\ReplacementClaim\Updated;
use App\ReplacementClaim;
use App\Subscription;
use Illuminate\Support\Facades\Notification;

class ReplacementClaimObserver
{
    /**
     * Handle to the replacement claim "creating" event.
     *
     * @param \App\ReplacementClaim $replacementClaim
     *
     * @return void
     */
    public function creating(ReplacementClaim $replacementClaim)
    {
        $replacementClaim->code = 'RC-'.substr(bin2hex(random_bytes(16)), 0, 16);
    }

    /**
     * Handle to the replacement claim "created" event.
     *
     * @param \App\ReplacementClaim $replacementClaim
     *
     * @return void
     */
    public function created(ReplacementClaim $replacementClaim)
    {
        $subscriptions = $replacementClaim->organization
            ->subscriptions()
            ->where(
                'subscriptions.notification',
                '=',
                array_search(Submitted::class, Subscription::AVAILABLE_NOTIFICATIONS)
            )
            ->with('character.user')
            ->get();

        $notifiables = $subscriptions->map(function (Subscription $subscription) use ($replacementClaim) {
            return $subscription->character->user;
        });

        Notification::send($notifiables, new Submitted($replacementClaim));
    }

    /**
     * Handle the replacement claim "updating" event.
     *
     * @param \App\ReplacementClaim $replacementClaim
     *
     * @return void
     */
    public function updating(ReplacementClaim $replacementClaim)
    {
        /** @var Character $character */
        $character = Character::find(request()->header(CheckCharacter::CHARACTER_HEADER));

        $replacementClaim->lastUpdatedBy()->associate($character);
    }

    /**
     * Handle the replacement claim "updated" event.
     *
     * @param \App\ReplacementClaim $replacementClaim
     *
     * @return void
     */
    public function updated(ReplacementClaim $replacementClaim)
    {
        $replacementClaim
            ->loadMissing('character.user')
            ->character
            ->user
            ->notify(new Updated($replacementClaim));
    }
}
