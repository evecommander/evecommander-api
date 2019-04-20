<?php

namespace App\JsonApi\Schemas;

use Neomerx\JsonApi\Schema\SchemaProvider;

class WingSchema extends SchemaProvider
{
    /**
     * @var string
     */
    protected $resourceType = 'wings';

    /**
     * @param $resource
     *      the domain record being serialized.
     *
     * @return string
     */
    public function getId($resource)
    {
        return (string) $resource->getRouteKey();
    }

    /**
     * @param \App\Wing $resource
     *                            the domain record being serialized.
     *
     * @return array
     */
    public function getAttributes($resource)
    {
        return [
            'api-id' => $resource->api_id,
            'name'   => $resource->name,
        ];
    }

    /**
     * @param \App\Wing $resource
     * @param bool      $isPrimary
     * @param array     $includeRelationships
     *
     * @return array
     */
    public function getRelationships($resource, $isPrimary, array $includeRelationships)
    {
        return [
            'fleet' => [
                self::SHOW_SELF    => true,
                self::SHOW_RELATED => true,
                self::SHOW_DATA    => isset($includeRelationships['fleet']),
                self::DATA         => function () use ($resource) {
                    return $resource->fleet;
                },
            ],

            'squads' => [
                self::SHOW_SELF    => true,
                self::SHOW_RELATED => true,
                self::META         => function () use ($resource) {
                    return ['count' => $resource->squads->count()];
                },
            ],

            'fleet-members' => [
                self::SHOW_SELF    => true,
                self::SHOW_RELATED => true,
                self::META         => function () use ($resource) {
                    return ['count' => $resource->fleetMembers->count()];
                },
            ],
        ];
    }
}
