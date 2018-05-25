<?php

namespace App\JsonApi\Schemas;

use Neomerx\JsonApi\Schema\SchemaProvider;

class RoleSchema extends SchemaProvider
{
    /**
     * @var string
     */
    protected $resourceType = 'roles';

    /**
     * @param \App\Role $resource
     *                            the domain record being serialized.
     *
     * @return string
     */
    public function getId($resource)
    {
        return (string) $resource->getKey();
    }

    /**
     * @param \App\Role $resource
     *                            the domain record being serialized.
     *
     * @return array
     */
    public function getAttributes($resource)
    {
        return [
            'name'        => $resource->name,
            'description' => $resource->description,
            'created-at'  => $resource->created_at->toAtomString(),
            'updated-at'  => $resource->updated_at->toAtomString(),
        ];
    }

    /**
     * @param \App\Role $resource
     * @param bool      $isPrimary
     * @param array     $includeRelationships
     *
     * @return array
     */
    public function getRelationships($resource, $isPrimary, array $includeRelationships)
    {
        return [
            'organization' => [
                self::SHOW_SELF => true,
                self::SHOW_RELATED => true,
                self::SHOW_DATA => isset($includeRelationships['organization']),
                self::SHOW_DATA => function () use ($resource) {
                    return $resource->organization;
                },
            ],

            'permissions' => [
                self::SHOW_SELF    => true,
                self::SHOW_RELATED => true,
            ],

            'characters' => [
                self::SHOW_SELF    => true,
                self::SHOW_RELATED => true,
            ],
        ];
    }
}
