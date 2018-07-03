<?php

namespace App\Policies;

use App\Abstracts\Organization;
use App\Policies\Interfaces\ResourcePolicyInterface;
use App\Policies\Traits\AuthorizesRelations;
use App\User;
use App\Doctrine;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class DoctrinePolicy implements ResourcePolicyInterface
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
     * Determine whether the user can view the doctrine.
     *
     * @param  User    $user
     * @param  Model   $doctrine
     * @param  Request $request
     * @return bool
     */
    public function read(User $user, Model $doctrine, Request $request): bool
    {
        /** @var Doctrine $doctrine */
        return $this->authorizeRelation($doctrine->organization, 'doctrines', 'read', $request);
    }

    /**
     * Determine whether the user can create doctrines.
     *
     * @param  User    $user
     * @param  string  $type
     * @param  Request $request
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

        return $this->authorizeRelation($organization, 'doctrines', 'modify', $request);
    }

    /**
     * Determine whether the user can update the doctrine.
     *
     * @param  User    $user
     * @param  Model   $doctrine
     * @param  Request $request
     * @return bool
     */
    public function update(User $user, Model $doctrine, Request $request): bool
    {
        /** @var Doctrine $doctrine */
        return $this->authorizeRelation($doctrine->organization, 'doctrines', 'modify', $request);
    }

    /**
     * Determine whether the user can delete the doctrine.
     *
     * @param  User    $user
     * @param  Model   $doctrine
     * @param  Request $request
     * @return bool
     */
    public function delete(User $user, Model $doctrine, Request $request): bool
    {
        /** @var Doctrine $doctrine */
        return $this->authorizeRelation($doctrine->organization, 'doctrines', 'modify', $request);
    }

    /**
     * @param Doctrine $doctrine
     * @param Request $request
     * @return bool
     */
    public function readOrganization(Doctrine $doctrine, Request $request): bool
    {
        return $request->user()->can('read', [$doctrine->organization, $request]);
    }

    /**
     * @param Doctrine $doctrine
     * @param Request $request
     * @return bool
     */
    public function modifyOrganization(Doctrine $doctrine, Request $request): bool
    {
        return false;
    }

    /**
     * @param Doctrine $doctrine
     * @param Request $request
     * @return bool
     */
    public function readFittings(Doctrine $doctrine, Request $request): bool
    {
        return $this->authorizeRelation($doctrine->organization, 'fittings', 'read', $request);
    }

    /**
     * @param Doctrine $doctrine
     * @param Request $request
     * @return bool
     */
    public function modifyFittings(Doctrine $doctrine, Request $request): bool
    {
        return $this->authorizeRelation($doctrine->organization, 'fittings', 'modify', $request);
    }

    /**
     * @param Doctrine $doctrine
     * @param Request $request
     * @return bool
     */
    public function readCreatedBy(Doctrine $doctrine, Request $request): bool
    {
        return $this->authorizeRelation($doctrine->organization, 'doctrines', 'read', $request);
    }

    /**
     * @param Doctrine $doctrine
     * @param Request $request
     * @return bool
     */
    public function modifyCreatedBy(Doctrine $doctrine, Request $request): bool
    {
        return false;
    }

    /**
     * @param Doctrine $doctrine
     * @param Request $request
     * @return bool
     */
    public function readLastUpdatedBy(Doctrine $doctrine, Request $request): bool
    {
        return $this->authorizeRelation($doctrine->organization, 'doctrines', 'read', $request);
    }

    /**
     * @param Doctrine $doctrine
     * @param Request $request
     * @return bool
     */
    public function modifyLastUpdatedBy(Doctrine $doctrine, Request $request): bool
    {
        return false;
    }
}
