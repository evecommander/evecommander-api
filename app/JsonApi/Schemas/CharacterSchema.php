<?php

namespace App\JsonApi\Schemas;

use Neomerx\JsonApi\Schema\SchemaProvider;

class CharacterSchema extends SchemaProvider
{
    /**
     * @var string
     */
    protected $resourceType = 'characters';

    /**
     * @param \App\Character $resource
     *                                 the domain record being serialized.
     *
     * @return string
     */
    public function getId($resource)
    {
        return (string) $resource->getRouteKey();
    }

    /**
     * @param \App\Character $resource
     *                                 the domain record being serialized.
     *
     * @return array
     */
    public function getAttributes($resource)
    {
        return [
            'name'       => $resource->name,
            'eve-id'     => $resource->api_id,
            'created-at' => $resource->created_at->toIso8601String(),
            'updated-at' => $resource->updated_at->toIso8601String(),
        ];
    }

    /**
     * @param \App\Character $resource
     * @param bool           $isPrimary
     * @param array          $includeRelationships
     *
     * @return array
     */
    public function getRelationships($resource, $isPrimary, array $includeRelationships)
    {
        return [
            'memberships' => [
                self::SHOW_SELF    => true,
                self::SHOW_RELATED => true,
            ],

            'replacementClaims' => [
                self::SHOW_SELF    => true,
                self::SHOW_RELATED => true,
            ],

            'invoices' => [
                self::SHOW_SELF    => true,
                self::SHOW_RELATED => true,
            ],

            'user' => [
                self::SHOW_SELF    => true,
                self::SHOW_RELATED => true,
            ],

            'token' => [
                self::SHOW_SELF    => true,
                self::SHOW_RELATED => true,
            ],

            'comments' => [
                self::SHOW_SELF    => true,
                self::SHOW_RELATED => true,
            ],

            'corporation' => [
                self::SHOW_SELF    => true,
                self::SHOW_RELATED => true,
            ],

            'notifications' => [
                self::SHOW_SELF    => true,
                self::SHOW_RELATED => true,
            ],

            'roles' => [
                self::SHOW_SELF    => true,
                self::SHOW_RELATED => true,
            ],

            'rsvps' => [
                self::SHOW_SELF    => true,
                self::SHOW_RELATED => true,
            ],
        ];
    }
}
