<?php

namespace App\Observers;

use App\Character;
use App\Http\Middleware\CheckCharacter;
use App\Membership;

class MembershipObserver
{
    /**
     * Handle to the membership "creating" event.
     *
     * @param  \App\Membership  $membership
     * @return void
     */
    public function creating(Membership $membership)
    {
        /** @var Character $character */
        $character = Character::find(request()->header(CheckCharacter::CHARACTER_HEADER));

        $membership->createdBy()->associate($character);
    }

    /**
     * Handle the membership "updating" event.
     *
     * @param  \App\Membership  $membership
     * @return void
     */
    public function updating(Membership $membership)
    {
        /** @var Character $character */
        $character = Character::find(request()->header(CheckCharacter::CHARACTER_HEADER));

        $membership->lastUpdatedBy()->associate($character);
    }
}
