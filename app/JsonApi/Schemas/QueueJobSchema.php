<?php

namespace App\JsonApi\Schemas;

use CloudCreativity\LaravelJsonApi\Queue\AsyncSchema;
use CloudCreativity\LaravelJsonApi\Queue\ClientJob;
use Neomerx\JsonApi\Schema\SchemaProvider;

class QueueJobSchema extends SchemaProvider
{
    use AsyncSchema;

    /**
     * @var string
     */
    protected $resourceType = 'queue-jobs';

    /**
     * @param ClientJob $resource
     *      the domain record being serialized.
     * @return string
     */
    public function getId($resource)
    {
        return (string) $resource->getRouteKey();
    }

    /**
     * @param ClientJob $resource
     *      the domain record being serialized.
     * @return array
     */
    public function getAttributes($resource)
    {
        return [
            'api' => $resource->api,
            'attempts' => $resource->attempts,
            'timeout' => $resource->timeout,
            'timeout-at' => $resource->timeout_at->toAtomString(),
            'tries' => $resource->tries,
            'failed' => $resource->failed,
            'completed-at' => $resource->completed_at->toAtomString(),
            'created-at' => $resource->created_at->toAtomString(),
            'updated-at' => $resource->updated_at->toAtomString(),
        ];
    }

    /**
     * @param ClientJob $resource
     * @param bool      $isPrimary
     * @param array     $includeRelationships
     *
     * @return array
     */
    public function getRelationships($resource, $isPrimary, array $includeRelationships)
    {
        return [
            'resource' => [
                self::SHOW_SELF    => true,
                self::SHOW_RELATED => true,
                self::SHOW_DATA    => isset($includeRelationships['resource']),
                self::DATA         => function () use ($resource) {
                    return $resource->getResource();
                },
            ],
        ];
    }
}
