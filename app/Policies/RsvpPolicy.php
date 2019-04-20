<?php

namespace App\Policies;

use App\Fleet;
use App\Policies\Interfaces\ResourcePolicyInterface;
use App\Policies\Traits\AuthorizesRelations;
use App\Rsvp;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Database\Eloquent\Model;

class RsvpPolicy implements ResourcePolicyInterface
{
    use HandlesAuthorization, AuthorizesRelations;

    /**
     * @param User   $user
     * @param string $type
     *
     * @return bool
     */
    public function index(User $user, string $type): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the rsvp.
     *
     * @param User  $user
     * @param Model $rsvp
     *
     * @return bool
     */
    public function read(User $user, Model $rsvp): bool
    {
        /* @var Rsvp $rsvp */
        return $user->can('read', [$rsvp->fleet]);
    }

    /**
     * Determine whether the user can create rsvps.
     *
     * @param User   $user
     * @param string $type
     *
     * @return bool
     */
    public function create(User $user, string $type): bool
    {
        $request = \request();

        if (!$request->has('fleet_id')) {
            return false;
        }

        // if the user can read the fleet it concerns, they can create the RSVP
        return $user->can('read', [Fleet::find($request->get('fleet_id'))]);
    }

    /**
     * Determine whether the user can update the rsvp.
     *
     * @param User  $user
     * @param Model $rsvp
     *
     * @return bool
     */
    public function update(User $user, Model $rsvp): bool
    {
        /* @var Rsvp $rsvp */
        return $user->characters()->where('id', $rsvp->character_id)->exists();
    }

    /**
     * Determine whether the user can delete the rsvp.
     *
     * @param User  $user
     * @param Model $rsvp
     *
     * @return bool
     */
    public function delete(User $user, Model $rsvp): bool
    {
        /* @var Rsvp $rsvp */
        return $this->update($user, $rsvp);
    }

    /**
     * @param User $user
     * @param Rsvp $rsvp
     *
     * @return bool
     */
    public function readCharacter(User $user, Rsvp $rsvp): bool
    {
        return $this->read($user, $rsvp);
    }

    /**
     * @param User $user
     * @param Rsvp $rsvp
     *
     * @return bool
     */
    public function modifyCharacter(User $user, Rsvp $rsvp): bool
    {
        return false;
    }

    /**
     * @param User $user
     * @param Rsvp $rsvp
     *
     * @return bool
     */
    public function readFleet(User $user, Rsvp $rsvp): bool
    {
        return $this->read($user, $rsvp);
    }

    /**
     * @param User $user
     * @param Rsvp $rsvp
     *
     * @return bool
     */
    public function modifyFleet(User $user, Rsvp $rsvp): bool
    {
        return false;
    }
}
