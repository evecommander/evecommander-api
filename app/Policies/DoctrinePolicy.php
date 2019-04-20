<?php

namespace App\Policies;

use App\Abstracts\Organization;
use App\Doctrine;
use App\Policies\Interfaces\ResourcePolicyInterface;
use App\Policies\Traits\AuthorizesRelations;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Database\Eloquent\Model;

class DoctrinePolicy implements ResourcePolicyInterface
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
     * Determine whether the user can view the doctrine.
     *
     * @param User    $user
     * @param Model   $doctrine
     *
     * @return bool
     */
    public function read(User $user, Model $doctrine): bool
    {
        /* @var Doctrine $doctrine */
        return $this->readRelationship($user, $doctrine->organization, 'doctrines');
    }

    /**
     * Determine whether the user can create doctrines.
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

        return $this->modifyRelationship($user, $organization, 'doctrines');
    }

    /**
     * Determine whether the user can update the doctrine.
     *
     * @param User    $user
     * @param Model   $doctrine
     *
     * @return bool
     */
    public function update(User $user, Model $doctrine): bool
    {
        /* @var Doctrine $doctrine */
        return $this->modifyRelationship($user, $doctrine->organization, 'doctrines');
    }

    /**
     * Determine whether the user can delete the doctrine.
     *
     * @param User    $user
     * @param Model   $doctrine
     *
     * @return bool
     */
    public function delete(User $user, Model $doctrine): bool
    {
        /* @var Doctrine $doctrine */
        return $this->modifyRelationship($user, $doctrine->organization, 'doctrines');
    }

    /**
     * @param User     $user
     * @param Doctrine $doctrine
     *
     * @return bool
     */
    public function readOrganization(User $user, Doctrine $doctrine): bool
    {
        return $user->can('read', [$doctrine->organization]);
    }

    /**
     * @param User     $user
     * @param Doctrine $doctrine
     *
     * @return bool
     */
    public function modifyOrganization(User $user, Doctrine $doctrine): bool
    {
        return false;
    }

    /**
     * @param User     $user
     * @param Doctrine $doctrine
     *
     * @return bool
     */
    public function readFittings(User $user, Doctrine $doctrine): bool
    {
        return $this->readRelationship($user, $doctrine->organization, 'fittings');
    }

    /**
     * @param User     $user
     * @param Doctrine $doctrine
     *
     * @return bool
     */
    public function modifyFittings(User $user, Doctrine $doctrine): bool
    {
        return $this->modifyRelationship($user, $doctrine->organization, 'fittings');
    }

    /**
     * @param User     $user
     * @param Doctrine $doctrine
     *
     * @return bool
     */
    public function readCreatedBy(User $user, Doctrine $doctrine): bool
    {
        return $this->read($user, $doctrine);
    }

    /**
     * @param User     $user
     * @param Doctrine $doctrine
     *
     * @return bool
     */
    public function modifyCreatedBy(User $user, Doctrine $doctrine): bool
    {
        return false;
    }

    /**
     * @param User     $user
     * @param Doctrine $doctrine
     *
     * @return bool
     */
    public function readLastUpdatedBy(User $user, Doctrine $doctrine): bool
    {
        return $this->readRelationship($user, $doctrine->organization, 'doctrines');
    }

    /**
     * @param User     $user
     * @param Doctrine $doctrine
     *
     * @return bool
     */
    public function modifyLastUpdatedBy(User $user, Doctrine $doctrine): bool
    {
        return false;
    }
}
