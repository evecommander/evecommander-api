<?php

namespace App\JsonApi\Schemas;

use Neomerx\JsonApi\Schema\SchemaProvider;

class SubscriptionSchema extends SchemaProvider
{
    /**
     * @var string
     */
    protected $resourceType = 'subscriptions';

    /**
     * @param \App\Subscription $resource
     *                                    the domain record being serialized.
     *
     * @return string
     */
    public function getId($resource)
    {
        return (string) $resource->getKey();
    }

    /**
     * @param \App\Subscription $resource
     *                                    the domain record being serialized.
     *
     * @return array
     */
    public function getAttributes($resource)
    {
        return [
            'settings'   => $resource->settings,
            'created-at' => $resource->created_at->toAtomString(),
            'updated-at' => $resource->updated_at->toAtomString(),
        ];
    }

    /**
     * @param \App\Subscription $resource
     * @param bool              $isPrimary
     * @param array             $includeRelationships
     *
     * @return array
     */
    public function getRelationships($resource, $isPrimary, array $includeRelationships)
    {
        return [
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
        ];
    }
}
