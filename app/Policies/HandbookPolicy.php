<?php

namespace App\Policies;

use App\Abstracts\Organization;
use App\Handbook;
use App\Policies\Interfaces\ResourcePolicyInterface;
use App\Policies\Traits\AuthorizesRelations;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class HandbookPolicy implements ResourcePolicyInterface
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
     * Determine whether the user can view the handbook.
     *
     * @param User    $user
     * @param Model   $handbook
     * @param Request $request
     *
     * @return bool
     */
    public function read(User $user, Model $handbook, Request $request): bool
    {
        /* @var Handbook $handbook */
        return $this->authorizeRelation($handbook->organization, 'handbooks', 'read', $request);
    }

    /**
     * Determine whether the user can create handbooks.
     *
     * @param User    $user
     * @param string  $type
     * @param Request $request
     *
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

        return $this->authorizeRelation($organization, 'fleet_types', 'modify', $request);
    }

    /**
     * Determine whether the user can update the handbook.
     *
     * @param User    $user
     * @param Model   $handbook
     * @param Request $request
     *
     * @return bool
     */
    public function update(User $user, Model $handbook, Request $request): bool
    {
        /* @var Handbook $handbook */
        return $this->authorizeRelation($handbook->organization, 'handbooks', 'modify', $request);
    }

    /**
     * Determine whether the user can delete the handbook.
     *
     * @param User    $user
     * @param Model   $handbook
     * @param Request $request
     *
     * @return bool
     */
    public function delete(User $user, Model $handbook, Request $request): bool
    {
        /* @var Handbook $handbook */
        return $this->authorizeRelation($handbook->organization, 'handbooks', 'modify', $request);
    }

    /**
     * @param Handbook $handbook
     * @param Request  $request
     *
     * @return bool
     */
    public function readOrganization(Handbook $handbook, Request $request): bool
    {
        return $request->user()->can('read', [$handbook->organization, $request]);
    }

    /**
     * @param Handbook $handbook
     * @param Request  $request
     *
     * @return bool
     */
    public function modifyOrganization(Handbook $handbook, Request $request): bool
    {
        return false;
    }

    /**
     * @param Handbook $handbook
     * @param Request  $request
     *
     * @return bool
     */
    public function readCreatedBy(Handbook $handbook, Request $request): bool
    {
        return $request->user()->can('read', [$handbook->organization, $request]);
    }

    /**
     * @param Handbook $handbook
     * @param Request  $request
     *
     * @return bool
     */
    public function modifyCreatedBy(Handbook $handbook, Request $request): bool
    {
        return false;
    }

    /**
     * @param Handbook $handbook
     * @param Request  $request
     *
     * @return bool
     */
    public function readLastUpdatedBy(Handbook $handbook, Request $request): bool
    {
        return $request->user()->can('read', [$handbook->organization, $request]);
    }

    /**
     * @param Handbook $handbook
     * @param Request  $request
     *
     * @return bool
     */
    public function modifyLastUpdatedBy(Handbook $handbook, Request $request): bool
    {
        return false;
    }
}
