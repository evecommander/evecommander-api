<?php

namespace App\Policies\Traits;

use App\Abstracts\Organization;
use App\Character;
use App\Http\Middleware\CheckCharacter;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

trait AuthorizesRelations
{
    /**
     * Determine whether the user can read the given relationship.
     *
     * @param  User    $user
     * @param  Model   $resource
     * @param  string  $relation
     * @param  Request $request
     * @return boolean
     */
    public function readRelationship(User $user, Model $resource, string $relation, Request $request): bool
    {
        return $this->authorizeRelation($resource, $relation, 'read', $request);
    }

    /**
     * Determine whether the user can modify the given relationship.
     *
     * @param  User    $user
     * @param  Model   $resource
     * @param  string  $relation
     * @param  Request $request
     * @return bool
     */
    public function modifyRelationship(User $user, Model $resource, string $relation, Request $request): bool
    {
        return $this->authorizeRelation($resource, $relation, 'modify', $request);
    }

    /**
     * @param  Model   $resource
     * @param  string  $relation
     * @param  string  $action
     * @param  Request $request
     * @return bool
     */
    protected function authorizeRelation(Model $resource, string $relation, string $action, Request $request): bool
    {
        $methodName = $action.Str::studly($relation);

        // if a specialized method is available for the relation, pass the buck to it
        if (is_callable([$this, $methodName])) {
            return $this->$methodName($resource, $request);
        }

        /** @var Character $character */
        $character = Character::find($request->header(CheckCharacter::CHARACTER_HEADER));

        if (!($resource instanceof Organization)) {
            return false;
        }

        // check if the character has the permission $relation_$action
        return $character->hasPermission(Str::snake("{$relation}_{$action}"), $resource);
    }
}