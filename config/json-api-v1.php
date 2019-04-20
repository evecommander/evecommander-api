<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Resolver
    |--------------------------------------------------------------------------
    |
    | The API's resolver is the class that works out the fully qualified
    | class name of adapters, schemas, authorizers and validators for your
    | resource types. We recommend using our default implementation but you
    | can override it here if desired.
    */
    'resolver' => \CloudCreativity\LaravelJsonApi\Resolver\ResolverFactory::class,

    /*
    |--------------------------------------------------------------------------
    | Root Namespace
    |--------------------------------------------------------------------------
    |
    | The root namespace for JSON API classes for this API. If `null`, the
    | namespace will default to `JsonApi` within your application's root
    | namespace (obtained via Laravel's `Application::getNamespace()`
    | method).
    |
    | The `by-resource` setting determines how your units are organised within
    | your root namespace.
    |
    | - true: e.g. \App\JsonApi\Posts\{Schema, Hydrator}
    | - false:
    |   - e.g. \App\JsonApi\Schemas\{User, Post, Comment}
    |   - e.g. \App\JsonApi\Hydrators\{User, Post, Comment}
    |
    */
    'namespace'   => null,
    'by-resource' => false,

    /*
    |--------------------------------------------------------------------------
    | Resources
    |--------------------------------------------------------------------------
    |
    | Here you map the list of JSON API resources in your API to the actual
    | record (model/entity) classes they relate to.
    |
    | For example, if you had a `posts` JSON API resource, that related to
    | an Eloquent model `App\Post`, your mapping would be:
    |
    | `'posts' => App\Post::class`
    */
    'resources' => [
        'users'                    => \App\User::class,
        'characters'               => \App\Character::class,
        'corporations'             => \App\Corporation::class,
        'alliances'                => \App\Alliance::class,
        'coalitions'               => \App\Coalition::class,
        'comments'                 => \App\Comment::class,
        'doctrines'                => \App\Doctrine::class,
        'fittings'                 => \App\Fitting::class,
        'fleets'                   => \App\Fleet::class,
        'wings'                    => \App\Wing::class,
        'squads'                   => \App\Squad::class,
        'fleet-members'            => \App\FleetMember::class,
        'fleet-types'              => \App\FleetType::class,
        'handbooks'                => \App\Handbook::class,
        'replacement-claims'       => \App\ReplacementClaim::class,
        'discounts'                => \App\Discount::class,
        'billing-conditions'       => \App\BillingCondition::class,
        'billing-condition-groups' => \App\BillingConditionGroup::class,
        'invoices'                 => \App\Invoice::class,
        'invoice-items'            => \App\InvoiceItem::class,
        'memberships'              => \App\Membership::class,
        'membership-fees'          => \App\MembershipFee::class,
        'membership-levels'        => \App\MembershipLevel::class,
        'notifications'            => \Illuminate\Notifications\DatabaseNotification::class,
        'permissions'              => \App\Permission::class,
        'oauth2-tokens'            => \App\OAuth2Token::class,
        'queue-jobs'               => \CloudCreativity\LaravelJsonApi\Queue\ClientJob::class,
        'roles'                    => \App\Role::class,
        'subscriptions'            => \App\Subscription::class,
        'rsvps'                    => \App\Rsvp::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Eloquent
    |--------------------------------------------------------------------------
    |
    | Whether your JSON API resources predominantly relate to Eloquent models.
    | This is used by the package's generators.
    |
    | You can override the setting here when running a generator. If the
    | setting here is `true` running a generator with `--no-eloquent` will
    | override it; if the setting is `false`, then `--eloquent` is the override.
    |
    */
    'use-eloquent' => true,

    /*
    |--------------------------------------------------------------------------
    | Jobs
    |--------------------------------------------------------------------------
    |
    | Defines settings for the asynchronous processing feature. We recommend
    | referring to the documentation on asynchronous processing if you are
    | using this feature.
    |
    | Note that if you use a different model class, it must implement the
    | asynchronous process interface.
    |
    */
    'jobs' => [
        'resource' => 'queue-jobs',
        'model'    => \CloudCreativity\LaravelJsonApi\Queue\ClientJob::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | URL
    |--------------------------------------------------------------------------
    |
    | The API's url, made up of a host, URL namespace and route name prefix.
    |
    | If a JSON API is handling an inbound request, the host will always be
    | detected from the inbound HTTP request. In other circumstances
    | (e.g. broadcasting), the host will be taken from the setting here.
    | If it is `null`, the `app.url` config setting is used as the default.
    | If you set `host` to `false`, the host will never be appended to URLs
    | for inbound requests.
    |
    | The name setting is the prefix for route names within this API.
    |
    */
    'url' => [
        'host'      => null,
        'namespace' => '/api/v1',
        'name'      => 'api:v1:',
    ],

    /*
    |--------------------------------------------------------------------------
    | Supported JSON API Extensions
    |--------------------------------------------------------------------------
    |
    | Refer to the JSON API spec for information on supported extensions.
    |
    */
    'supported-ext' => null,

    /*
    |--------------------------------------------------------------------------
    | Encoding Media Types
    |--------------------------------------------------------------------------
    |
    | This defines the JSON API encoding used for particular media
    | types supported by your API. This array can contain either
    | media types as values, or can be keyed by a media type with the value
    | being the options that are passed to the `json_encode` method.
    |
    | These values are also used for Content Negotiation. If a client requests
    | via the HTTP Accept header a media type that is not listed here,
    | a 406 Not Acceptable response will be sent.
    |
    | If you want to support media types that do not return responses with JSON
    | API encoded data, you can do this at runtime. Refer to the
    | Content Negotiation chapter in the docs for details.
    |
    */
    'encoding' => [
        'application/vnd.api+json',
    ],

    /*
    |--------------------------------------------------------------------------
    | Decoding Media Types
    |--------------------------------------------------------------------------
    |
    | This defines the media types that your API can receive from clients.
    | This array is keyed by expected media types, with the value being the
    | service binding that decodes the media type.
    |
    | These values are also used for Content Negotiation. If a client sends
    | a content type not listed here, it will receive a
    | 415 Unsupported Media Type response.
    |
    | Decoders can also be calculated at runtime, and/or you can add support
    | for media types for specific resources or requests. Refer to the
    | Content Negotiation chapter in the docs for details.
    |
    */
    'decoding' => [
        'application/vnd.api+json',
    ],

    /*
    |--------------------------------------------------------------------------
    | Providers
    |--------------------------------------------------------------------------
    |
    | Providers allow vendor packages to include resources in your API. E.g.
    | a Shopping Cart vendor package might define the `orders` and `payments`
    | JSON API resources.
    |
    | A package author will define a provider class in their package that you
    | can add here. E.g. for our shopping cart example, the provider could be
    | `Vendor\ShoppingCart\JsonApi\ResourceProvider`.
    |
    */
    'providers' => [],

];
