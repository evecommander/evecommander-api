<?php

namespace App\JsonApi\Schemas;

use Neomerx\JsonApi\Schema\SchemaProvider;

class User extends SchemaProvider
{
    /**
     * @var string
     */
    protected $resourceType = 'users';

    /**
     * @param \App\User $resource
     *                            the domain record being serialized.
     *
     * @return string
     */
    public function getId($resource)
    {
        return (string) $resource->getKey();
    }

    /**
     * @param \App\User $resource
     *                            the domain record being serialized.
     *
     * @return array
     */
    public function getAttributes($resource)
    {
        return [
            'email'      => $resource->email,
            'settings'   => $resource->settings,
            'created-at' => $resource->created_at->toIso8601String(),
            'updated-at' => $resource->updated_at->toIso8601String(),
        ];
    }

    /**
     * @param \App\User $resource
     * @param bool      $isPrimary
     * @param array     $includeRelationships
     *
     * @return array
     */
    public function getRelationships($resource, $isPrimary, array $includeRelationships)
    {
        return [
            'notifications' => [
                self::SHOW_SELF    => true,
                self::SHOW_RELATED => true,
            ],

            'readNotifications' => [
                self::SHOW_SELF    => true,
                self::SHOW_RELATED => true,
            ],

            'unreadNotifications' => [
                self::SHOW_SELF    => true,
                self::SHOW_RELATED => true,
            ],

            'characters' => [
                self::SHOW_SELF    => true,
                self::SHOW_RELATED => true,
            ],
        ];
    }
}
