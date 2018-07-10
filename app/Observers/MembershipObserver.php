<?php

namespace App\Observers;

use App\Character;
use App\Http\Middleware\CheckCharacter;
use App\Membership;
use App\Notifications\Membership\Created;
use App\Notifications\Membership\Updated;
use App\Role;

class MembershipObserver
{
    /**
     * Handle to the membership "creating" event.
     *
     * @param \App\Membership $membership
     *
     * @return void
     */
    public function creating(Membership $membership)
    {
        /** @var Character $character */
        $character = Character::find(request()->header(CheckCharacter::CHARACTER_HEADER));

        $membership->createdBy()->associate($character);
    }

    /**
     * Handle to the membership "created" event.
     *
     * @param \App\Membership $membership
     *
     * @return void
     */
    public function created(Membership $membership)
    {
        $membership->member->notify(new Created($membership));

        // add appropriate roles to the new member (if they are a Character)
        if ($membership->member instanceof Character) {
            $membership->member->roles()->attach($membership->membershipLevel->roles->map(function (Role $item) {
                return $item->id;
            }));
        }
    }

    /**
     * Handle the membership "updating" event.
     *
     * @param \App\Membership $membership
     *
     * @return void
     */
    public function updating(Membership $membership)
    {
        /** @var Character $character */
        $character = Character::find(request()->header(CheckCharacter::CHARACTER_HEADER));

        $membership->lastUpdatedBy()->associate($character);
    }

    /**
     * Handle to the membership "updated" event.
     *
     * @param \App\Membership $membership
     *
     * @return void
     */
    public function updated(Membership $membership)
    {
        $membership->member->notify(new Updated($membership));
    }
}
