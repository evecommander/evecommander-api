<?php

namespace App\JsonApi\Schemas;

use App\JsonApi\ProvidesMeta;
use Neomerx\JsonApi\Schema\SchemaProvider;

class InvoiceSchema extends SchemaProvider
{
    use ProvidesMeta;

    /**
     * @var string
     */
    protected $resourceType = 'invoices';

    /**
     * @param \App\Invoice $resource
     *                               the domain record being serialized.
     *
     * @return string
     */
    public function getId($resource)
    {
        return (string) $resource->getRouteKey();
    }

    /**
     * @param \App\Invoice $resource
     *                               the domain record being serialized.
     *
     * @return array
     */
    public function getAttributes($resource)
    {
        return [
            'code'          => $resource->code,
            'title'         => $resource->title,
            'status'        => $resource->status,
            'total'         => $resource->total,
            'due-date'      => $resource->due_date->toIso8601String(),
            'hard-due-date' => $resource->hard_due_date->toIso8601String(),
            'created-at'    => $resource->created_at->toIso8601String(),
            'updated-at'    => $resource->updated_at->toIso8601String(),
        ];
    }

    /**
     * @param \App\Invoice $resource
     * @param bool         $isPrimary
     * @param array        $includeRelationships
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

            'notifications' => [
                self::SHOW_SELF    => true,
                self::SHOW_RELATED => true,
                self::META => function () use ($resource) {
                    return $this->notificationsCounts($resource);
                }
            ],

            'payments' => [
                self::SHOW_SELF    => true,
                self::SHOW_RELATED => true,
                self::META => function () use ($resource) {
                    return [
                        'count' => $resource->payments->count()
                    ];
                }
            ],

            'issuer' => [
                self::SHOW_SELF    => true,
                self::SHOW_RELATED => true,
                self::SHOW_DATA    => isset($includeRelationships['issuer']),
                self::DATA         => function () use ($resource) {
                    return $resource->issuer;
                },
            ],

            'recipient' => [
                self::SHOW_SELF    => true,
                self::SHOW_RELATED => true,
                self::SHOW_DATA    => isset($includeRelationships['recipient']),
                self::DATA         => function () use ($resource) {
                    return $resource->recipient;
                },
            ],

            'items' => [
                self::SHOW_SELF    => true,
                self::SHOW_RELATED => true,
                self::META => function () use ($resource) {
                    return [
                        'count' => $resource->items->count()
                    ];
                }
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
