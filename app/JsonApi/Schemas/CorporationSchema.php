<?php

namespace App\JsonApi\Schemas;

use App\JsonApi\ProvidesMeta;
use Neomerx\JsonApi\Schema\SchemaProvider;

class CorporationSchema extends SchemaProvider
{
    use ProvidesMeta;

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
        return (string) $resource->getRouteKey();
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
                self::META         => function () use ($resource) {
                    return $this->handbooksCount($resource);
                },
            ],

            'members' => [
                self::SHOW_SELF    => true,
                self::SHOW_RELATED => true,
                self::META         => function () use ($resource) {
                    return $this->membersCount($resource);
                },
            ],

            'defaultMembershipLevel' => [
                self::SHOW_SELF    => true,
                self::SHOW_RELATED => true,
            ],

            'membershipLevels' => [
                self::SHOW_SELF    => true,
                self::SHOW_RELATED => true,
                self::META         => function () use ($resource) {
                    return $this->membershipLevelsCount($resource);
                },
            ],

            'memberships' => [
                self::SHOW_SELF    => true,
                self::SHOW_RELATED => true,
                self::META         => function () use ($resource) {
                    return $this->membersCount($resource);
                },
            ],

            'replacementClaims' => [
                self::SHOW_SELF    => true,
                self::SHOW_RELATED => true,
                self::META         => function () use ($resource) {
                    return $this->replacementClaimsCounts($resource);
                },
            ],

            'invoices' => [
                self::SHOW_SELF    => true,
                self::SHOW_RELATED => true,
                self::META         => function () use ($resource) {
                    return $this->issuedInvoicesCounts($resource);
                },
            ],

            'receivedInvoices' => [
                self::SHOW_SELF    => true,
                self::SHOW_RELATED => true,
                self::META         => function () use ($resource) {
                    return $this->receivedInvoicesCounts($resource);
                },
            ],

            'notifications' => [
                self::SHOW_SELF    => true,
                self::SHOW_RELATED => true,
                self::META         => function () use ($resource) {
                    return $this->notificationsCounts($resource);
                },
            ],

            'alliance' => [
                self::SHOW_SELF    => true,
                self::SHOW_RELATED => true,
                self::SHOW_DATA    => true,
            ],

            'characters' => [
                self::SHOW_SELF    => true,
                self::SHOW_RELATED => true,
                self::META         => function () use ($resource) {
                    return [
                        'count' => $resource->characters->count(),
                    ];
                },
            ],

            'roles' => [
                self::SHOW_SELF    => true,
                self::SHOW_RELATED => true,
                self::META         => function () use ($resource) {
                    return $this->rolesCount($resource);
                },
            ],

            'subscriptions' => [
                self::SHOW_SELF    => true,
                self::SHOW_RELATED => true,
                self::META         => function () use ($resource) {
                    return $this->subscriptionsCount($resource);
                },
            ],
        ];
    }
}
