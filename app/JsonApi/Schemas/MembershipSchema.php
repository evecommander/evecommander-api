<?php

namespace App\JsonApi\Schemas;

use App\JsonApi\ProvidesMeta;
use Neomerx\JsonApi\Schema\SchemaProvider;

class MembershipSchema extends SchemaProvider
{
    use ProvidesMeta;

    /**
     * @var string
     */
    protected $resourceType = 'memberships';

    /**
     * @param \App\Membership $resource
     *                                  the domain record being serialized.
     *
     * @return string
     */
    public function getId($resource)
    {
        return (string) $resource->getRouteKey();
    }

    /**
     * @param \App\Membership $resource
     *                                  the domain record being serialized.
     *
     * @return array
     */
    public function getAttributes($resource)
    {
        return [
            'notes'      => $resource->notes,
            'created-at' => $resource->created_at->toIso8601String(),
            'updated-at' => $resource->updated_at->toIso8601String(),
            'deleted-at' => !is_null($resource->deleted_at) ? $resource->deleted_at->toIso8601String() : null,
        ];
    }

    /**
     * @param \App\Membership $resource
     * @param bool            $isPrimary
     * @param array           $includeRelationships
     *
     * @return array
     */
    public function getRelationships($resource, $isPrimary, array $includeRelationships)
    {
        return [
            'notifications' => [
                self::SHOW_SELF    => true,
                self::SHOW_RELATED => true,
                self::META         => function () use ($resource) {
                    return $this->notificationsCounts($resource);
                },
            ],

            'membership-level' => [
                self::SHOW_SELF    => true,
                self::SHOW_RELATED => true,
                self::SHOW_DATA    => isset($includeRelationships['membership-level']),
                self::DATA         => function () use ($resource) {
                    return $resource->membershipLevel;
                },
            ],

            'organization' => [
                self::SHOW_SELF    => true,
                self::SHOW_RELATED => true,
                self::SHOW_DATA    => isset($includeRelationships['organization']),
                self::DATA         => function () use ($resource) {
                    return $resource->organization;
                },
            ],

            'member' => [
                self::SHOW_SELF    => true,
                self::SHOW_RELATED => true,
                self::SHOW_DATA    => isset($includeRelationships['member']),
                self::DATA         => function () use ($resource) {
                    return $resource->member;
                },
            ],

            'created-by' => [
                self::SHOW_SELF    => true,
                self::SHOW_RELATED => true,
                self::SHOW_DATA    => isset($includeRelationships['created-by']),
                self::DATA         => function () use ($resource) {
                    return $resource->createdBy;
                },
            ],

            'last-updated-by' => [
                self::SHOW_SELF    => true,
                self::SHOW_RELATED => true,
                self::SHOW_DATA    => isset($includeRelationships['last-updated-by']),
                self::DATA         => function () use ($resource) {
                    return $resource->lastUpdatedBy;
                },
            ],
        ];
    }
}
