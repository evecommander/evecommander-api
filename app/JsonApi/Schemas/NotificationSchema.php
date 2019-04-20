<?php

namespace App\JsonApi\Schemas;

use Illuminate\Notifications\DatabaseNotification;
use Neomerx\JsonApi\Schema\SchemaProvider;

class NotificationSchema extends SchemaProvider
{

    /**
     * @var string
     */
    protected $resourceType = 'notifications';

    /**
     * @param DatabaseNotification $resource
     *      the domain record being serialized.
     * @return string
     */
    public function getId($resource)
    {
        return (string) $resource->getRouteKey();
    }

    /**
     * @param DatabaseNotification $resource
     *      the domain record being serialized.
     * @return array
     */
    public function getAttributes($resource)
    {
        return [
            'type'       => $resource->type,
            'data'       => $resource->data,
            'read-at'    => $resource->read_at,
            'created-at' => $resource->created_at->toAtomString(),
            'updated-at' => $resource->updated_at->toAtomString(),
        ];
    }

    /**
     * @param DatabaseNotification $resource
     * @param bool         $isPrimary
     * @param array        $includeRelationships
     *
     * @return array
     */
    public function getRelationships($resource, $isPrimary, array $includeRelationships)
    {
        return [
            'notifiable' => [
                self::SHOW_SELF    => true,
                self::SHOW_RELATED => true,
                self::SHOW_DATA    => isset($includeRelationships['notifiable']),
                self::DATA         => function () use ($resource) {
                    return $resource->notifiable;
                },
            ],
        ];
    }
}
