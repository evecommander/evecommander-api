<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        \App\Alliance::class         => \App\Policies\AlliancePolicy::class,
        \App\BillingCondition::class => \App\Policies\BillingConditionPolicy::class,
        \App\Character::class        => \App\Policies\CharacterPolicy::class,
        \App\Coalition::class        => \App\Policies\CoalitionPolicy::class,
        \App\Comment::class          => \App\Policies\CommentPolicy::class,
        \App\Corporation::class      => \App\Policies\CorporationPolicy::class,
        \App\Discount::class         => \App\Policies\DiscountPolicy::class,
        \App\Doctrine::class         => \App\Policies\DoctrinePolicy::class,
        \App\Fitting::class          => \App\Policies\FittingPolicy::class,
        \App\Fleet::class            => \App\Policies\FleetPolicy::class,
        \App\FleetType::class        => \App\Policies\FleetTypePolicy::class,
        \App\Handbook::class         => \App\Policies\HandbookPolicy::class,
        \App\Invoice::class          => \App\Policies\InvoicePolicy::class,
        \App\InvoiceItem::class      => \App\Policies\InvoiceItemPolicy::class,
        \App\Membership::class       => \App\Policies\MembershipPolicy::class,
        \App\MembershipFee::class    => \App\Policies\MembershipFeePolicy::class,
        \App\MembershipLevel::class  => \App\Policies\MembershipLevelPolicy::class,
        \App\OAuth2Token::class      => \App\Policies\OAuth2TokenPolicy::class,
        \App\Permission::class       => \App\Policies\PermissionPolicy::class,
        \App\ReplacementClaim::class => \App\Policies\ReplacementClaimPolicy::class,
        \App\Role::class             => \App\Policies\RolePolicy::class,
        \App\Rsvp::class             => \App\Policies\RsvpPolicy::class,
        \App\Subscription::class     => \App\Policies\SubscriptionPolicy::class,
        \App\User::class             => \App\Policies\UserPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
