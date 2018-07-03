<?php

namespace App\Policies;

use App\Policies\Interfaces\ResourcePolicyInterface;
use App\User;
use App\Character;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class CharacterPolicy implements ResourcePolicyInterface
{
    use HandlesAuthorization;

    const READ_ONLY_RELATIONS = [
        'readNotifications',
        'unreadNotifications',
        'fulfilledInvoices',
        'overdueInvoices',
        'pendingInvoices',
        'defaultInvoices',
        'corporation'
    ];

    /**
     * @param User $user
     * @param string $type
     * @param Request $request
     * @return bool
     */
    public function index(User $user, string $type, Request $request): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the character.
     *
     * @param User $user
     * @param Model $character
     * @param Request $request
     * @return bool
     */
    public function read(User $user, Model $character, Request $request): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create characters.
     *
     * @param User $user
     * @param string $type
     * @param Request $request
     * @return bool
     */
    public function create(User $user, string $type, Request $request): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the character.
     *
     * @param  User    $user
     * @param  Model   $character
     * @param  Request $request
     * @return bool
     */
    public function update(User $user, Model $character, Request $request): bool
    {
        /** @var Character $character */
        return $user->characters()->where('characters.id', '=', $character->id)->exists();
    }

    /**
     * Determine whether the user can delete the character.
     *
     * @param  User    $user
     * @param  Model   $character
     * @param  Request $request
     * @return bool
     */
    public function delete(User $user, Model $character, Request $request): bool
    {
        /** @var Character $character */
        return $user->characters()->where('characters.id', '=', $character->id)->exists();
    }

    /**
     * Determine whether the user can read the relationship.
     *
     * @param  User    $user
     * @param  Model   $character
     * @param  string  $relation
     * @param  Request $request
     * @return bool
     */
    public function readRelationship(User $user, Model $character, string $relation, Request $request): bool
    {
        /** @var Character $character */
        return $user->characters()->where('characters.id', '=', $character->id)->exists();
    }

    /**
     * Determine whether the user can modify the relationship.
     *
     * @param  User    $user
     * @param  Model   $character
     * @param  string  $relation
     * @param  Request $request
     * @return bool
     */
    public function modifyRelationship(User $user, Model $character, string $relation, Request $request): bool
    {
        if (in_array($relation, self::READ_ONLY_RELATIONS)) {
            return false;
        }

        /** @var Character $character */
        return $user->characters()->where('characters.id', '=', $character->id)->exists();
    }
}
