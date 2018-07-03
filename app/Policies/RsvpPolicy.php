<?php

namespace App\Policies;

use App\Fleet;
use App\Http\Middleware\CheckCharacter;
use App\Policies\Interfaces\ResourcePolicyInterface;
use App\Policies\Traits\AuthorizesRelations;
use App\Rsvp;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class RsvpPolicy implements ResourcePolicyInterface
{
    use HandlesAuthorization, AuthorizesRelations;

    /**
     * @param User    $user
     * @param string  $type
     * @param Request $request
     *
     * @return bool
     */
    public function index(User $user, string $type, Request $request): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the rsvp.
     *
     * @param User    $user
     * @param Model   $rsvp
     * @param Request $request
     *
     * @return bool
     */
    public function read(User $user, Model $rsvp, Request $request): bool
    {
        /* @var Rsvp $rsvp */
        return $user->can('read', [$rsvp->fleet, $request]);
    }

    /**
     * Determine whether the user can create rsvps.
     *
     * @param User    $user
     * @param string  $type
     * @param Request $request
     *
     * @return bool
     */
    public function create(User $user, string $type, Request $request): bool
    {
        if (!$request->has('fleet_id')) {
            return false;
        }

        // if the user can read the fleet it concerns, they can create the RSVP
        return $user->can('read', [Fleet::find($request->get('fleet_id')), $request]);
    }

    /**
     * Determine whether the user can update the rsvp.
     *
     * @param User    $user
     * @param Model   $rsvp
     * @param Request $request
     *
     * @return bool
     */
    public function update(User $user, Model $rsvp, Request $request): bool
    {
        /* @var Rsvp $rsvp */
        return $rsvp->character_id === $request->header(CheckCharacter::CHARACTER_HEADER);
    }

    /**
     * Determine whether the user can delete the rsvp.
     *
     * @param User    $user
     * @param Model   $rsvp
     * @param Request $request
     *
     * @return bool
     */
    public function delete(User $user, Model $rsvp, Request $request): bool
    {
        /* @var Rsvp $rsvp */
        return $rsvp->character_id === $request->header(CheckCharacter::CHARACTER_HEADER);
    }

    /**
     * @param Rsvp    $rsvp
     * @param Request $request
     *
     * @return bool
     */
    public function readCharacter(Rsvp $rsvp, Request $request): bool
    {
        return $this->read($request->user(), $rsvp, $request);
    }

    /**
     * @param Rsvp    $rsvp
     * @param Request $request
     *
     * @return bool
     */
    public function modifyCharacter(Rsvp $rsvp, Request $request): bool
    {
        return false;
    }

    /**
     * @param Rsvp    $rsvp
     * @param Request $request
     *
     * @return bool
     */
    public function readFleet(Rsvp $rsvp, Request $request): bool
    {
        return $this->read($request->user(), $rsvp, $request);
    }

    /**
     * @param Rsvp    $rsvp
     * @param Request $request
     *
     * @return bool
     */
    public function modifyFleet(Rsvp $rsvp, Request $request): bool
    {
        return false;
    }
}
