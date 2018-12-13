<?php

namespace App\JsonApi\Schemas;

use App\FleetMember;
use Neomerx\JsonApi\Schema\SchemaProvider;

class FleetMemberSchema extends SchemaProvider
{

    /**
     * @var string
     */
    protected $resourceType = 'fleet-members';

    /**
     * @param $resource
     *      the domain record being serialized.
     * @return string
     */
    public function getId($resource)
    {
        return (string) $resource->getRouteKey();
    }

    /**
     * @param FleetMember $resource
     *      the domain record being serialized.
     * @return array
     */
    public function getAttributes($resource)
    {
        return [
            'character-api-id' => $resource->character_api_id,
            'join-time' => $resource->join_time->toIso8601String(),
            'role' => $resource->role,
            'ship-type-id' => $resource->ship_type_id,
            'solar-system-id' => $resource->solar_system_id,
            'station-id' => $resource->station_id,
            'takes-fleet-warp' => $resource->takes_fleet_warp,
        ];
    }

    /**
     * @param \App\FleetMember $resource
     * @param bool             $isPrimary
     * @param array            $includeRelationships
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

            'wing' => [
                self::SHOW_SELF    => true,
                self::SHOW_RELATED => true,
                self::SHOW_DATA    => isset($includeRelationships['wing']),
                self::DATA         => function () use ($resource) {
                    return $resource->wing;
                },
            ],

            'squad' => [
                self::SHOW_SELF    => true,
                self::SHOW_RELATED => true,
                self::SHOW_DATA    => isset($includeRelationships['squad']),
                self::DATA         => function () use ($resource) {
                    return $resource->squad;
                },
            ],

            'character' => [
                self::SHOW_SELF    => true,
                self::SHOW_RELATED => true,
                self::SHOW_DATA    => isset($includeRelationships['character']),
                self::DATA         => function () use ($resource) {
                    return $resource->character;
                },
            ],
        ];
    }
}
