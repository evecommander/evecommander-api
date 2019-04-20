<?php

namespace App\Policies\Traits;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

trait AuthorizesRelations
{
    /**
     * Determine whether the user can read the given relationship.
     *
     * @param User   $user
     * @param Model  $resource
     * @param string $relation
     *
     * @return bool
     */
    public function readRelationship(User $user, Model $resource, string $relation): bool
    {
        return $this->authorizeRelation($user, $resource, $relation, 'read');
    }

    /**
     * Determine whether the user can modify the given relationship.
     *
     * @param User   $user
     * @param Model  $resource
     * @param string $relation
     *
     * @return bool
     */
    public function modifyRelationship(User $user, Model $resource, string $relation): bool
    {
        return $this->authorizeRelation($user, $resource, $relation, 'modify');
    }

    /**
     * @param User   $user
     * @param Model  $organization
     * @param string $relation
     * @param string $action
     *
     * @return bool
     */
    protected function authorizeRelation(User $user, Model $organization, string $relation, string $action): bool
    {
        $methodName = $action.Str::studly($relation);

        // if a specialized method is available for the relation, pass the buck to it
        if (is_callable([$this, $methodName])) {
            return $this->$methodName($user, $organization);
        }

        return $user->hasCharacterWithPermission($organization, $relation, $action);
    }
}
