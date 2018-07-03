<?php

namespace App\Observers;

use App\Character;
use App\Fleet;
use App\Http\Middleware\CheckCharacter;

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
}
