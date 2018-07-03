<?php

namespace App\Observers;

use App\Character;
use App\Http\Middleware\CheckCharacter;
use App\MembershipLevel;

class MembershipLevelObserver
{
    /**
     * Handle to the membership level "creating" event.
     *
     * @param \App\MembershipLevel $membershipLevel
     *
     * @return void
     */
    public function creating(MembershipLevel $membershipLevel)
    {
        /** @var Character $character */
        $character = Character::find(request()->header(CheckCharacter::CHARACTER_HEADER));

        $membershipLevel->createdBy()->associate($character);
    }

    /**
     * Handle the membership level "updating" event.
     *
     * @param \App\MembershipLevel $membershipLevel
     *
     * @return void
     */
    public function updating(MembershipLevel $membershipLevel)
    {
        /** @var Character $character */
        $character = Character::find(request()->header(CheckCharacter::CHARACTER_HEADER));

        $membershipLevel->lastUpdatedBy()->associate($character);
    }
}
