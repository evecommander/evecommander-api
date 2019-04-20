<?php

namespace App\Policies;

use App\Abstracts\Organization;
use App\Policies\Interfaces\ResourcePolicyInterface;
use App\Policies\Traits\AuthorizesRelations;
use App\Subscription;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Database\Eloquent\Model;

class SubscriptionPolicy implements ResourcePolicyInterface
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
     * Determine whether the user can view the subscription.
     *
     * @param User    $user
     * @param Model   $subscription
     *
     * @return bool
     */
    public function read(User $user, Model $subscription): bool
    {
        /* @var Subscription $subscription */
        return $this->readRelationship($user, $subscription->organization, 'subscriptions');
    }

    /**
     * Determine whether the user can create subscriptions.
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

        return $user->can('read', [$organization]);
    }

    /**
     * Determine whether the user can update the subscription.
     *
     * @param User    $user
     * @param Model   $subscription
     *
     * @return bool
     */
    public function update(User $user, Model $subscription): bool
    {
        /* @var Subscription $subscription */
        return $user->characters()->where('id', $subscription->character_id)->exists();
    }

    /**
     * Determine whether the user can delete the subscription.
     *
     * @param User    $user
     * @param Model   $subscription
     *
     * @return bool
     */
    public function delete(User $user, Model $subscription): bool
    {
        /* @var Subscription $subscription */
        return $this->update($user, $subscription);
    }

    /**
     * @param User         $user
     * @param Subscription $subscription
     *
     * @return bool
     */
    public function readOrganization(User $user, Subscription $subscription): bool
    {
        return $this->read($user, $subscription);
    }

    /**
     * @param User         $user
     * @param Subscription $subscription
     *
     * @return bool
     */
    public function modifyOrganization(User $user, Subscription $subscription): bool
    {
        return false;
    }

    /**
     * @param User         $user
     * @param Subscription $subscription
     *
     * @return bool
     */
    public function readCharacter(User $user, Subscription $subscription): bool
    {
        return $this->read($user, $subscription);
    }

    /**
     * @param User         $user
     * @param Subscription $subscription
     *
     * @return bool
     */
    public function modifyCharacter(User $user, Subscription $subscription): bool
    {
        return false;
    }
}
