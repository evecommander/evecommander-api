<?php

namespace App\JsonApi\Schemas;

use Neomerx\JsonApi\Schema\SchemaProvider;

class SquadSchema extends SchemaProvider
{
    /**
     * @var string
     */
    protected $resourceType = 'squads';

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
     * @param \App\Squad $resource
     *                             the domain record being serialized.
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
     * @param \App\Squad $resource
     * @param bool       $isPrimary
     * @param array      $includeRelationships
     *
     * @return array
     */
    public function getRelationships($resource, $isPrimary, array $includeRelationships)
    {
        return [
            'wing' => [
                self::SHOW_SELF    => true,
                self::SHOW_RELATED => true,
                self::SHOW_DATA    => isset($includeRelationships['wing']),
                self::DATA         => function () use ($resource) {
                    return $resource->wing;
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
