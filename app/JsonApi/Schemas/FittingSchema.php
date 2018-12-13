<?php

namespace App\JsonApi\Schemas;

use Neomerx\JsonApi\Schema\SchemaProvider;

class FittingSchema extends SchemaProvider
{
    /**
     * @var string
     */
    protected $resourceType = 'fittings';

    /**
     * @param \App\Fitting $resource
     *                               the domain record being serialized.
     *
     * @return string
     */
    public function getId($resource)
    {
        return (string) $resource->getRouteKey();
    }

    /**
     * @param \App\Fitting $resource
     *                               the domain record being serialized.
     *
     * @return array
     */
    public function getAttributes($resource)
    {
        return [
            'api-id'      => $resource->api_id,
            'name'        => $resource->name,
            'description' => $resource->description,
            'created-at'  => $resource->created_at->toIso8601String(),
            'updated-at'  => $resource->updated_at->toIso8601String(),
        ];
    }

    /**
     * @param \App\Fitting $resource
     * @param bool         $isPrimary
     * @param array        $includeRelationships
     *
     * @return array
     */
    public function getRelationships($resource, $isPrimary, array $includeRelationships)
    {
        return [
            'organization' => [
                self::SHOW_SELF    => true,
                self::SHOW_RELATED => true,
                self::SHOW_DATA    => isset($includeRelationships['organization']),
                self::DATA         => function () use ($resource) {
                    return $resource->organization;
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

            'doctrine' => [
                self::SHOW_SELF    => true,
                self::SHOW_RELATED => true,
                self::SHOW_DATA    => isset($includeRelationships['doctrine']),
                self::DATA         => function () use ($resource) {
                    return $resource->doctrine;
                },
            ],

            'replacement-claims' => [
                self::SHOW_SELF    => true,
                self::SHOW_RELATED => true,
                self::META         => function () use ($resource) {
                    return [
                        'count' => $resource->replacementClaims->count(),
                    ];
                },
            ],
        ];
    }
}
