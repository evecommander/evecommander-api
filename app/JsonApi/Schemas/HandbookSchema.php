<?php

namespace App\JsonApi\Schemas;

use Neomerx\JsonApi\Schema\SchemaProvider;

class HandbookSchema extends SchemaProvider
{
    /**
     * @var string
     */
    protected $resourceType = 'handbooks';

    /**
     * @param \App\Handbook $resource
     *                                the domain record being serialized.
     *
     * @return string
     */
    public function getId($resource)
    {
        return (string) $resource->getRouteKey();
    }

    /**
     * @param \App\Handbook $resource
     *                                the domain record being serialized.
     *
     * @return array
     */
    public function getAttributes($resource)
    {
        return [
            'title'       => $resource->title,
            'description' => $resource->description,
            'content'     => $resource->content,
            'order'       => $resource->order,
            'created-at'  => $resource->created_at->toIso8601String(),
            'updated-at'  => $resource->updated_at->toIso8601String(),
        ];
    }

    /**
     * @param \App\Handbook $resource
     * @param bool          $isPrimary
     * @param array         $includeRelationships
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
