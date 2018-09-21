<?php

namespace App\JsonApi\Schemas;

use App\JsonApi\ProvidesMeta;
use Neomerx\JsonApi\Schema\SchemaProvider;

class FleetSchema extends SchemaProvider
{
    use ProvidesMeta;

    /**
     * @var string
     */
    protected $resourceType = 'fleets';

    /**
     * @param \App\Fleet $resource
     *                             the domain record being serialized.
     *
     * @return string
     */
    public function getId($resource)
    {
        return (string) $resource->getRouteKey();
    }

    /**
     * @param \App\Fleet $resource
     *                             the domain record being serialized.
     *
     * @return array
     */
    public function getAttributes($resource)
    {
        return [
            'title'       => $resource->title,
            'description' => $resource->description,
            'status'      => $resource->status,
            'start-time'  => $resource->start_time->toIso8601String(),
            'end-time'    => $resource->end_time->toIso8601String(),
            'created-at'  => $resource->created_at->toIso8601String(),
            'updated-at'  => $resource->updated_at->toIso8601String(),
        ];
    }

    /**
     * @param \App\Fleet $resource
     * @param bool       $isPrimary
     * @param array      $includeRelationships
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

            'comments' => [
                self::SHOW_SELF    => true,
                self::SHOW_RELATED => true,
                self::META         => function () use ($resource) {
                    return [
                        'count' => $resource->comments->count(),
                    ];
                },
            ],

            'fleetType' => [
                self::SHOW_SELF    => true,
                self::SHOW_RELATED => true,
                self::SHOW_DATA    => isset($includeRelationships['fleetType']),
                self::DATA         => function () use ($resource) {
                    return $resource->fleetType;
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
        ];
    }
}
