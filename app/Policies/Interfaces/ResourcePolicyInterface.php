<?php

namespace App\Policies\Interfaces;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

interface ResourcePolicyInterface
{
    /**
     * Determine whether the user can view an index list of the given type
     *
     * @param User    $user
     * @param string  $type
     * @param Request $request
     * @return bool
     */
    public function index(User $user, string $type, Request $request): bool;

    /**
     * Determine whether the user can view the record.
     *
     * @param User    $user
     * @param Model   $record
     * @param Request $request
     * @return bool
     */
    public function read(User $user, Model $record, Request $request): bool;

    /**
     * Determine whether the user can create a record of the given type.
     *
     * @param User    $user
     * @param string  $type
     * @param Request $request
     * @return bool
     */
    public function create(User $user, string $type, Request $request): bool;

    /**
     * Determine whether the user can update the record.
     *
     * @param User    $user
     * @param Model   $record
     * @param Request $request
     * @return bool
     */
    public function update(User $user, Model $record, Request $request): bool;

    /**
     * Determine whether the user can delete the record.
     *
     * @param User    $user
     * @param Model   $record
     * @param Request $request
     * @return bool
     */
    public function delete(User $user, Model $record, Request $request): bool;

    /**
     * Determine whether the user can read the relationship.
     *
     * @param User    $user
     * @param Model   $record
     * @param string  $relation
     * @param Request $request
     * @return bool
     */
    public function readRelationship(User $user, Model $record, string $relation, Request $request): bool;

    /**
     * Determine whether the user can modify the relationship.
     *
     * @param User    $user
     * @param Model   $record
     * @param string  $relation
     * @param Request $request
     * @return bool
     */
    public function modifyRelationship(User $user, Model $record, string $relation, Request $request): bool;
}