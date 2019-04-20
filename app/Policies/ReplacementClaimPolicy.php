<?php

namespace App\Policies;

use App\Abstracts\Organization;
use App\Alliance;
use App\Coalition;
use App\Corporation;
use App\Policies\Interfaces\ResourcePolicyInterface;
use App\Policies\Traits\AuthorizesRelations;
use App\ReplacementClaim;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ReplacementClaimPolicy implements ResourcePolicyInterface
{
    use HandlesAuthorization, AuthorizesRelations;

    /**
     * @param User    $user
     * @param string  $type
     *
     * @return bool
     */
    public function index(User $user, string $type): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the replacement claim.
     *
     * @param User    $user
     * @param Model   $replacementClaim
     *
     * @return bool
     */
    public function read(User $user, Model $replacementClaim): bool
    {
        /* @var ReplacementClaim $replacementClaim */
        return $this->readRelationship($user, $replacementClaim->organization, 'replacement_claims');
    }

    /**
     * Determine whether the user can create replacement claims.
     *
     * @param User    $user
     * @param string  $type
     *
     * @return bool
     */
    public function create(User $user, string $type): bool
    {
        $request = \request();

        // this is run before validation so reject bad requests
        if (!$request->has('organization_type') || !$request->has('organization_id')) {
            return false;
        }

        /** @var Organization $organization */
        $organization = $request->get('organization_type')::find($request->get('organization_id'));

        if ($organization instanceof Coalition) {
            return $user->characters()->with(['corporation.alliance.coalition' => function (Builder $query) use ($organization) {
                $query->where('coalitions.id', '=', $organization->id);
            }])->exists();
        }

        if ($organization instanceof Alliance) {
            return $user->characters()->with(['corporation.alliance' => function (Builder $query) use ($organization) {
                $query->where('alliances.id', '=', $organization->id);
            }])->exists();
        }

        /** @var Corporation $organization */
        return $user->characters()->with(['corporation' => function (Builder $query) use ($organization) {
            $query->where('corporations.id', '=', $organization->id);
        }])->exists();
    }

    /**
     * Determine whether the user can update the replacement claim.
     *
     * @param User    $user
     * @param Model   $replacementClaim
     *
     * @return bool
     */
    public function update(User $user, Model $replacementClaim): bool
    {
        /* @var ReplacementClaim $replacementClaim */
        return $this->modifyRelationship($user, $replacementClaim->organization, 'replacement_claims');
    }

    /**
     * Determine whether the user can delete the replacement claim.
     *
     * @param User    $user
     * @param Model   $replacementClaim
     *
     * @return bool
     */
    public function delete(User $user, Model $replacementClaim): bool
    {
        /* @var ReplacementClaim $replacementClaim */
        return $this->modifyRelationship($user, $replacementClaim->organization, 'replacement_claims');
    }

    /**
     * @param User             $user
     * @param ReplacementClaim $replacementClaim
     *
     * @return bool
     */
    public function readOrganization(User $user, ReplacementClaim $replacementClaim): bool
    {
        return $user->can('read', [$replacementClaim->organization]);
    }

    /**
     * @param User             $user
     * @param ReplacementClaim $replacementClaim
     *
     * @return bool
     */
    public function modifyOrganization(User $user, ReplacementClaim $replacementClaim): bool
    {
        return false;
    }

    /**
     * @param User             $user
     * @param ReplacementClaim $replacementClaim
     *
     * @return bool
     */
    public function readCharacter(User $user, ReplacementClaim $replacementClaim): bool
    {
        return $this->read($user, $replacementClaim);
    }

    /**
     * @param User             $user
     * @param ReplacementClaim $replacementClaim
     *
     * @return bool
     */
    public function modifyCharacter(User $user, ReplacementClaim $replacementClaim): bool
    {
        return false;
    }

    /**
     * @param User             $user
     * @param ReplacementClaim $replacementClaim
     *
     * @return bool
     */
    public function readComments(User $user, ReplacementClaim $replacementClaim): bool
    {
        return $this->read($user, $replacementClaim);
    }

    /**
     * @param User             $user
     * @param ReplacementClaim $replacementClaim
     *
     * @return bool
     */
    public function modifyComments(User $user, ReplacementClaim $replacementClaim): bool
    {
        return $this->update($user, $replacementClaim);
    }

    /**
     * @param User             $user
     * @param ReplacementClaim $replacementClaim
     *
     * @return bool
     */
    public function readFitting(User $user, ReplacementClaim $replacementClaim): bool
    {
        return $this->read($user, $replacementClaim);
    }

    /**
     * @param User             $user
     * @param ReplacementClaim $replacementClaim
     *
     * @return bool
     */
    public function modifyFitting(User $user, ReplacementClaim $replacementClaim): bool
    {
        return $this->update($user, $replacementClaim);
    }

    /**
     * @param User             $user
     * @param ReplacementClaim $replacementClaim
     *
     * @return bool
     */
    public function readLastUpdatedBy(User $user, ReplacementClaim $replacementClaim): bool
    {
        return $this->read($user, $replacementClaim);
    }

    /**
     * @param User             $user
     * @param ReplacementClaim $replacementClaim
     *
     * @return bool
     */
    public function modifyLastUpdatedBy(User $user, ReplacementClaim $replacementClaim): bool
    {
        return false;
    }
}
