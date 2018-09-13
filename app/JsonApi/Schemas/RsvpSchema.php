<?php

namespace App\JsonApi\Schemas;

use Neomerx\JsonApi\Schema\SchemaProvider;

class RsvpSchema extends SchemaProvider
{
    /**
     * @var string
     */
    protected $resourceType = 'rsvps';

    /**
     * @param \App\Rsvp $resource
     *                            the domain record being serialized.
     *
     * @return string
     */
    public function getId($resource)
    {
        return (string) $resource->getRouteKey();
    }

    /**
     * @param \App\Rsvp $resource
     *                            the domain record being serialized.
     *
     * @return array
     */
    public function getAttributes($resource)
    {
        return [
            'response'           => $resource->response,
            'notes'              => $resource->notes,
            'confirmed'          => $resource->confirmed,
            'confirmation-notes' => $resource->confirmation_notes,
            'created-at'         => $resource->created_at->toAtomString(),
            'updated-at'         => $resource->updated_at->toAtomString(),
        ];
    }

    /**
     * @param \App\Rsvp $resource
     * @param bool      $isPrimary
     * @param array     $includeRelationships
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

            'fleet' => [
                self::SHOW_SELF    => true,
                self::SHOW_RELATED => true,
                self::SHOW_DATA    => isset($includeRelationships['fleet']),
                self::DATA         => function () use ($resource) {
                    return $resource->fleet;
                },
            ],
        ];
    }
}
