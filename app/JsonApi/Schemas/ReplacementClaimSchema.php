<?php

namespace App\JsonApi\Schemas;

use Neomerx\JsonApi\Schema\SchemaProvider;

class ReplacementClaimSchema extends SchemaProvider
{
    /**
     * @var string
     */
    protected $resourceType = 'replacement-claims';

    /**
     * @param \App\ReplacementClaim $resource
     *                                        the domain record being serialized.
     *
     * @return string
     */
    public function getId($resource)
    {
        return (string) $resource->getRouteKey();
    }

    /**
     * @param \App\ReplacementClaim $resource
     *                                        the domain record being serialized.
     *
     * @return array
     */
    public function getAttributes($resource)
    {
        return [
            'killmail-id'   => $resource->killmail_id,
            'killmail-hash' => $resource->killmail_hash,
            'total'         => $resource->total,
            'status'        => $resource->status,
            'created-at'    => $resource->created_at->toIso8601String(),
            'updated-at'    => $resource->updated_at->toIso8601String(),
        ];
    }

    /**
     * @param \App\ReplacementClaim $resource
     * @param bool                  $isPrimary
     * @param array                 $includeRelationships
     *
     * @return array
     */
    public function getRelationships($resource, $isPrimary, array $includeRelationships)
    {
        return [
            'comments' => [
                self::SHOW_SELF    => true,
                self::SHOW_RELATED => true,
                self::META => function () use ($resource) {
                    return [
                        'count' => $resource->comments->count()
                    ];
                }
            ],

            'character' => [
                self::SHOW_SELF    => true,
                self::SHOW_RELATED => true,
                self::SHOW_DATA    => isset($includeRelationships['character']),
                self::DATA         => function () use ($resource) {
                    return $resource->character;
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

            'fitting' => [
                self::SHOW_SELF    => true,
                self::SHOW_RELATED => true,
                self::SHOW_DATA    => isset($includeRelationships['fitting']),
                self::DATA         => function () use ($resource) {
                    return $resource->fitting;
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
