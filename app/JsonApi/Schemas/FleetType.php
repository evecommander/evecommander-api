<?php

namespace App\JsonApi\Schemas;

use Neomerx\JsonApi\Schema\SchemaProvider;

class FleetType extends SchemaProvider
{

    /**
     * @var string
     */
    protected $resourceType = 'fleet-types';

    /**
     * @param \App\FleetType $resource
     *      the domain record being serialized.
     * @return string
     */
    public function getId($resource)
    {
        return (string) $resource->getKey();
    }

    /**
     * @param \App\FleetType $resource
     *      the domain record being serialized.
     * @return array
     */
    public function getAttributes($resource)
    {
        return [
            'name' => $resource->name,
            'description' => $resource->description,
            'created-at' => $resource->created_at->toIso8601String(),
            'updated-at' => $resource->updated_at->toIso8601String(),
        ];
    }

    /**
     * @param \App\FleetType $resource
     * @param bool $isPrimary
     * @param array $includeRelationships
     * @return array
     */
    public function getRelationships($resource, $isPrimary, array $includeRelationships)
    {
        return [
            'fleets' => [
                self::SHOW_SELF => true,
                self::SHOW_RELATED => true
            ],

            'owner' => [
                self::SHOW_SELF => true,
                self::SHOW_RELATED => true,
                self::SHOW_DATA => isset($includeRelationships['owner']),
                self::DATA => function () use ($resource) {
                    return $resource->owner;
                }
            ]
        ];
    }
}

