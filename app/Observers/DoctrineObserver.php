<?php

namespace App\Observers;

use App\Character;
use App\Doctrine;
use App\Http\Middleware\CheckCharacter;

class DoctrineObserver
{
    /**
     * Handle to the doctrine "creating" event.
     *
     * @param \App\Doctrine $doctrine
     *
     * @return void
     */
    public function creating(Doctrine $doctrine)
    {
        /** @var Character $character */
        $character = Character::find(request()->header(CheckCharacter::CHARACTER_HEADER));

        $doctrine->createdBy()->associate($character);
    }

    /**
     * Handle the doctrine "updating" event.
     *
     * @param \App\Doctrine $doctrine
     *
     * @return void
     */
    public function updating(Doctrine $doctrine)
    {
        /** @var Character $character */
        $character = Character::find(request()->header(CheckCharacter::CHARACTER_HEADER));

        $doctrine->createdBy()->associate($character);
    }
}
