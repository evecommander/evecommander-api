<?php

namespace App\JsonApi\Schemas;

use Neomerx\JsonApi\Schema\SchemaProvider;

class MembershipLevelSchema extends SchemaProvider
{
    /**
     * @var string
     */
    protected $resourceType = 'membership-levels';

    /**
     * @param \App\MembershipLevel $resource
     *                                       the domain record being serialized.
     *
     * @return string
     */
    public function getId($resource)
    {
        return (string) $resource->getKey();
    }

    /**
     * @param \App\MembershipLevel $resource
     *                                       the domain record being serialized.
     *
     * @return array
     */
    public function getAttributes($resource)
    {
        return [
            'name'           => $resource->name,
            'description'    => $resource->description,
            'dues'           => $resource->dues,
            'dues-structure' => $resource->dues_structure,
            'created-at'     => $resource->created_at->toIso8601String(),
            'updated-at'     => $resource->updated_at->toIso8601String(),
        ];
    }

    /**
     * @param \App\MembershipLevel $resource
     * @param bool                 $isPrimary
     * @param array                $includeRelationships
     *
     * @return array
     */
    public function getRelationships($resource, $isPrimary, array $includeRelationships)
    {
        return [
            'memberships' => [
                self::SHOW_SELF    => true,
                self::SHOW_RELATED => true,
            ],

            'owner' => [
                self::SHOW_SELF    => true,
                self::SHOW_RELATED => true,
                self::SHOW_DATA    => isset($includeRelationships['owner']),
                self::DATA         => function () use ($resource) {
                    return $resource->owner;
                },
            ],

            'createdBy' => [
                self::SHOW_SELF    => true,
                self::SHOW_RELATED => true,
                self::SHOW_DATA    => isset($includeRelationships['createdBy']),
                self::DATA         => function () use ($resource) {
                    return $resource->createdBy;
                },
            ],

            'lastUpdatedBy' => [
                self::SHOW_SELF    => true,
                self::SHOW_RELATED => true,
                self::SHOW_DATA    => isset($includeRelationships['lastUpdatedBy']),
                self::DATA         => function () use ($resource) {
                    return $resource->lastUpdatedBy;
                },
            ],

            'permissions' => [
                self::SHOW_SELF    => true,
                self::SHOW_RELATED => true,
            ],
        ];
    }
}
