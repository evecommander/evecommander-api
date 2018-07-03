<?php

namespace App\Observers;

use App\Character;
use App\Handbook;
use App\Http\Middleware\CheckCharacter;

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
}
