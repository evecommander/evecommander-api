<?php

namespace App\JsonApi\Schemas;

use Neomerx\JsonApi\Schema\SchemaProvider;

class CorporationSchema extends SchemaProvider
{
    /**
     * @var string
     */
    protected $resourceType = 'corporations';

    /**
     * @param \App\Corporation $resource
     *                                   the domain record being serialized.
     *
     * @return string
     */
    public function getId($resource)
    {
        return (string) $resource->getKey();
    }

    /**
     * @param \App\Corporation $resource
     *                                   the domain record being serialized.
     *
     * @return array
     */
    public function getAttributes($resource)
    {
        return [
            'api-id'                   => $resource->api_id,
            'name'                     => $resource->name,
            'default-membership-level' => $resource->default_membership_level,
            'settings'                 => $resource->settings,
            'mass-subscribables'       => $resource->mass_subscribables,
            'created-at'               => $resource->created_at->toIso8601String(),
            'updated-at'               => $resource->updated_at->toIso8601String(),
        ];
    }

    /**
     * @param \App\Corporation $resource
     * @param bool             $isPrimary
     * @param array            $includeRelationships
     *
     * @return array
     */
    public function getRelationships($resource, $isPrimary, array $includeRelationships)
    {
        return [
            'handbooks' => [
                self::SHOW_SELF    => true,
                self::SHOW_RELATED => true,
            ],

            'members' => [
                self::SHOW_SELF    => true,
                self::SHOW_RELATED => true,
            ],

            'defaultMembershipLevel' => [
                self::SHOW_SELF    => true,
                self::SHOW_RELATED => true,
            ],

            'membershipLevels' => [
                self::SHOW_SELF    => true,
                self::SHOW_RELATED => true,
            ],

            'memberships' => [
                self::SHOW_SELF    => true,
                self::SHOW_RELATED => true,
            ],

            'claims' => [
                self::SHOW_SELF    => true,
                self::SHOW_RELATED => true,
            ],

            'invoices' => [
                self::SHOW_SELF    => true,
                self::SHOW_RELATED => true,
            ],

            'fulfilledInvoices' => [
                self::SHOW_SELF    => true,
                self::SHOW_RELATED => true,
            ],

            'overdueInvoices' => [
                self::SHOW_SELF    => true,
                self::SHOW_RELATED => true,
            ],

            'pendingInvoices' => [
                self::SHOW_SELF    => true,
                self::SHOW_RELATED => true,
            ],

            'defaultInvoices' => [
                self::SHOW_SELF    => true,
                self::SHOW_RELATED => true,
            ],

            'issuedInvoices' => [
                self::SHOW_SELF    => true,
                self::SHOW_RELATED => true,
            ],

            'fulfilledIssuedInvoices' => [
                self::SHOW_SELF    => true,
                self::SHOW_RELATED => true,
            ],

            'overdueIssuedInvoices' => [
                self::SHOW_SELF    => true,
                self::SHOW_RELATED => true,
            ],

            'pendingIssuedInvoices' => [
                self::SHOW_SELF    => true,
                self::SHOW_RELATED => true,
            ],

            'defaultIssuedInvoices' => [
                self::SHOW_SELF    => true,
                self::SHOW_RELATED => true,
            ],

            'notifications' => [
                self::SHOW_SELF    => true,
                self::SHOW_RELATED => true,
            ],

            'readNotifications' => [
                self::SHOW_SELF    => true,
                self::SHOW_RELATED => true,
            ],

            'unreadNotifications' => [
                self::SHOW_SELF    => true,
                self::SHOW_RELATED => true,
            ],

            'alliance' => [
                self::SHOW_SELF    => true,
                self::SHOW_RELATED => true,
                self::SHOW_DATA    => true,
            ],

            'characters' => [
                self::SHOW_SELF    => true,
                self::SHOW_RELATED => true,
            ],

            'roles' => [
                self::SHOW_SELF    => true,
                self::SHOW_RELATED => true,
            ],

            'subscriptions' => [
                self::SHOW_SELF    => true,
                self::SHOW_RELATED => true,
            ],
        ];
    }
}
