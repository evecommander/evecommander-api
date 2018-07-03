<?php

namespace App\Policies;

use App\Abstracts\Organization;
use App\Http\Middleware\CheckCharacter;
use App\Policies\Interfaces\ResourcePolicyInterface;
use App\Policies\Traits\AuthorizesRelations;
use App\User;
use App\Subscription;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class SubscriptionPolicy implements ResourcePolicyInterface
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
     * Determine whether the user can view the subscription.
     *
     * @param  User    $user
     * @param  Model   $subscription
     * @param  Request $request
     * @return bool
     */
    public function read(User $user, Model $subscription, Request $request): bool
    {
        /** @var Subscription $subscription */
        return $this->authorizeRelation($subscription->organization, 'subscriptions', 'read', $request) ||
            $subscription->character_id === $request->header(CheckCharacter::CHARACTER_HEADER);
    }

    /**
     * Determine whether the user can create subscriptions.
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

        return $user->can('read', [$organization, $request]);
    }

    /**
     * Determine whether the user can update the subscription.
     *
     * @param  User    $user
     * @param  Model   $subscription
     * @param  Request $request
     * @return bool
     */
    public function update(User $user, Model $subscription, Request $request): bool
    {
        /** @var Subscription $subscription */
        return $subscription->character_id === $request->header(CheckCharacter::CHARACTER_HEADER);
    }

    /**
     * Determine whether the user can delete the subscription.
     *
     * @param  User    $user
     * @param  Model   $subscription
     * @param  Request $request
     * @return bool
     */
    public function delete(User $user, Model $subscription, Request $request): bool
    {
        /** @var Subscription $subscription */
        return $subscription->character_id === $request->header(CheckCharacter::CHARACTER_HEADER);
    }

    /**
     * @param Subscription $subscription
     * @param Request $request
     * @return bool
     */
    public function readOrganization(Subscription $subscription, Request $request): bool
    {
        return $this->read($request->user(), $subscription, $request);
    }

    /**
     * @param Subscription $subscription
     * @param Request $request
     * @return bool
     */
    public function modifyOrganization(Subscription $subscription, Request $request): bool
    {
        return false;
    }

    /**
     * @param Subscription $subscription
     * @param Request $request
     * @return bool
     */
    public function readCharacter(Subscription $subscription, Request $request): bool
    {
        return $this->read($request->user(), $subscription, $request);
    }

    /**
     * @param Subscription $subscription
     * @param Request $request
     * @return bool
     */
    public function modifyCharacter(Subscription $subscription, Request $request): bool
    {
        return false;
    }
}
