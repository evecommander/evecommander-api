<?php

namespace App\JsonApi\Schemas;

use Neomerx\JsonApi\Schema\SchemaProvider;

class PermissionSchema extends SchemaProvider
{
    /**
     * @var string
     */
    protected $resourceType = 'permissions';

    /**
     * @param \App\Permission $resource
     *                                  the domain record being serialized.
     *
     * @return string
     */
    public function getId($resource)
    {
        return (string) $resource->getRouteKey();
    }

    /**
     * @param \App\Permission $resource
     *                                  the domain record being serialized.
     *
     * @return array
     */
    public function getAttributes($resource)
    {
        return [
            'name'        => $resource->name,
            'description' => $resource->description,
            'slug'        => $resource->slug,
            'created-at'  => $resource->created_at->toIso8601String(),
            'updated-at'  => $resource->updated_at->toIso8601String(),
        ];
    }

    /**
     * @param \App\Permission $resource
     * @param bool            $isPrimary
     * @param array           $includeRelationships
     *
     * @return array
     */
    public function getRelationships($resource, $isPrimary, array $includeRelationships)
    {
        return [
            'membership-levels' => [
                self::SHOW_SELF    => true,
                self::SHOW_RELATED => true,
                self::META         => function () use ($resource) {
                    return [
                        'count' => $resource->membershipLevels->count(),
                    ];
                },
            ],

            'roles' => [
                self::SHOW_SELF    => true,
                self::SHOW_RELATED => true,
                self::META         => function () use ($resource) {
                    return [
                        'count' => $resource->roles->count(),
                    ];
                },
            ],
        ];
    }
}
