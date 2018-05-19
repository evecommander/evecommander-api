<?php

namespace App\JsonApi\Schemas;

use Neomerx\JsonApi\Schema\SchemaProvider;

class CommentSchema extends SchemaProvider
{
    /**
     * @var string
     */
    protected $resourceType = 'comments';

    /**
     * @param \App\Comment $resource
     *                               the domain record being serialized.
     *
     * @return string
     */
    public function getId($resource)
    {
        return (string) $resource->getKey();
    }

    /**
     * @param \App\Comment $resource
     *                               the domain record being serialized.
     *
     * @return array
     */
    public function getAttributes($resource)
    {
        return [
            'text'       => $resource->text,
            'created-at' => $resource->created_at->toIso8601String(),
            'updated-at' => $resource->updated_at->toIso8601String(),
        ];
    }

    /**
     * @param \App\Comment $resource
     * @param bool         $isPrimary
     * @param array        $includeRelationships
     *
     * @return array
     */
    public function getRelationships($resource, $isPrimary, array $includeRelationships)
    {
        return [
            'character' => [
                self::SHOW_SELF    => true,
                self::SHOW_RELATED => true,
                self::SHOW_DATA    => true,
            ],

            'commentable' => [
                self::SHOW_SELF    => true,
                self::SHOW_RELATED => true,
                self::SHOW_DATA    => true,
            ],
        ];
    }
}
