<?php

namespace App\JsonApi\Schemas;

use Neomerx\JsonApi\Schema\SchemaProvider;

class OAuth2TokenSchema extends SchemaProvider
{
    /**
     * @var string
     */
    protected $resourceType = 'o-auth2-tokens';

    /**
     * @param \App\OAuth2Token $resource
     *                                   the domain record being serialized.
     *
     * @return string
     */
    public function getId($resource)
    {
        return (string) $resource->getRouteKey();
    }

    /**
     * @param \App\OAuth2Token $resource
     *                                   the domain record being serialized.
     *
     * @return array
     */
    public function getAttributes($resource)
    {
        return [
            'access-token'  => $resource->access_token,
            'refresh-token' => $resource->refresh_token,
            'expires-at'    => $resource->expires_on->toIso8601String(),
            'created-at'    => $resource->created_at->toIso8601String(),
            'updated-at'    => $resource->updated_at->toIso8601String(),
        ];
    }

    /**
     * @param \App\OAuth2Token $resource
     * @param bool             $isPrimary
     * @param array            $includeRelationships
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
        ];
    }
}
