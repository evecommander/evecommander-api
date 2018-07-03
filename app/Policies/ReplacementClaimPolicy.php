<?php

namespace App\Policies;

use App\Abstracts\Organization;
use App\Alliance;
use App\Character;
use App\Coalition;
use App\Corporation;
use App\Http\Middleware\CheckCharacter;
use App\Policies\Interfaces\ResourcePolicyInterface;
use App\Policies\Traits\AuthorizesRelations;
use App\User;
use App\ReplacementClaim;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class ReplacementClaimPolicy implements ResourcePolicyInterface
{
    use HandlesAuthorization, AuthorizesRelations;

    /**
     * @param User $user
     * @param string $type
     * @param Request $request
     * @return bool
     */
    public function index(User $user, string $type, Request $request): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the replacement claim.
     *
     * @param  User    $user
     * @param  Model   $replacementClaim
     * @param  Request $request
     * @return bool
     */
    public function read(User $user, Model $replacementClaim, Request $request): bool
    {
        /** @var ReplacementClaim $replacementClaim */
        return $this->authorizeRelation($replacementClaim->organization, 'replacement_claims', 'read', $request);
    }

    /**
     * Determine whether the user can create replacement claims.
     *
     * @param User $user
     * @param string $type
     * @param Request $request
     * @return bool
     */
    public function create(User $user, string $type, Request $request): bool
    {
        // this is run before validation so reject bad requests
        if (!$request->has('organization_type') || !$request->has('organization_id')) {
            return false;
        }

        /** @var Organization $organization */
        $organization = $request->get('organization_type')::find($request->get('organization_id'));

        /** @var Character $character */
        $character = Character::find($request->header(CheckCharacter::CHARACTER_HEADER));

        if ($organization instanceof Coalition) {
            return $character->corporation()->with(['alliance.coalition' => function (Builder $query) use ($organization) {
                $query->where('coalitions.id', '=', $organization->id);
            }])->exists();
        }

        if ($organization instanceof Alliance) {
            return $character->corporation()->with(['alliance' => function (Builder $query) use ($organization) {
                $query->where('alliances.id', '=', $organization->id);
            }])->exists();
        }

        // $organization is a corporation
        return $organization->members()->where('member_id', '=', $character)->exists();
    }

    /**
     * Determine whether the user can update the replacement claim.
     *
     * @param  User    $user
     * @param  Model   $replacementClaim
     * @param  Request $request
     * @return bool
     */
    public function update(User $user, Model $replacementClaim, Request $request): bool
    {
        /** @var ReplacementClaim $replacementClaim */
        return $this->authorizeRelation($replacementClaim->organization, 'replacement_claims', 'modify', $request);
    }

    /**
     * Determine whether the user can delete the replacement claim.
     *
     * @param  User    $user
     * @param  Model   $replacementClaim
     * @param  Request $request
     * @return bool
     */
    public function delete(User $user, Model $replacementClaim, Request $request): bool
    {
        /** @var ReplacementClaim $replacementClaim */
        return $this->authorizeRelation($replacementClaim->organization, 'replacement_claims', 'modify', $request);
    }

    /**
     * @param ReplacementClaim $replacementClaim
     * @param Request $request
     * @return bool
     */
    public function readOrganization(ReplacementClaim $replacementClaim, Request $request): bool
    {
        return $request->user()->can('read', [$replacementClaim->organization, $request]);
    }

    /**
     * @param ReplacementClaim $replacementClaim
     * @param Request $request
     * @return bool
     */
    public function modifyOrganization(ReplacementClaim $replacementClaim, Request $request): bool
    {
        return false;
    }

    /**
     * @param ReplacementClaim $replacementClaim
     * @param Request $request
     * @return bool
     */
    public function readCharacter(ReplacementClaim $replacementClaim, Request $request): bool
    {
        return $this->read($request->user(), $replacementClaim, $request);
    }

    /**
     * @param ReplacementClaim $replacementClaim
     * @param Request $request
     * @return bool
     */
    public function modifyCharacter(ReplacementClaim $replacementClaim, Request $request): bool
    {
        return false;
    }

    /**
     * @param ReplacementClaim $replacementClaim
     * @param Request $request
     * @return bool
     */
    public function readComments(ReplacementClaim $replacementClaim, Request $request): bool
    {
        return $this->read($request->user(), $replacementClaim, $request);
    }

    /**
     * @param ReplacementClaim $replacementClaim
     * @param Request $request
     * @return bool
     */
    public function modifyComments(ReplacementClaim $replacementClaim, Request $request): bool
    {
        return $this->update($request->user(), $replacementClaim, $request);
    }

    /**
     * @param ReplacementClaim $replacementClaim
     * @param Request $request
     * @return bool
     */
    public function readFitting(ReplacementClaim $replacementClaim, Request $request): bool
    {
        return $this->read($request->user(), $replacementClaim, $request);
    }

    /**
     * @param ReplacementClaim $replacementClaim
     * @param Request $request
     * @return bool
     */
    public function modifyFitting(ReplacementClaim $replacementClaim, Request $request): bool
    {
        return $this->update($request->user(), $replacementClaim, $request);
    }
}
