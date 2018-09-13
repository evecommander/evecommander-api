<?php

namespace App\JsonApi\Schemas;

use Neomerx\JsonApi\Schema\SchemaProvider;

class InvoiceItemSchema extends SchemaProvider
{
    /**
     * @var string
     */
    protected $resourceType = 'invoice-items';

    /**
     * @param \App\InvoiceItem $resource
     *                                   the domain record being serialized.
     *
     * @return string
     */
    public function getId($resource)
    {
        return (string) $resource->getRouteKey();
    }

    /**
     * @param \App\InvoiceItem $resource
     *                                   the domain record being serialized.
     *
     * @return array
     */
    public function getAttributes($resource)
    {
        return [
            'name'        => $resource->name,
            'description' => $resource->description,
            'quantity'    => $resource->quantity,
            'cost'        => $resource->cost,
            'created-at'  => $resource->created_at->toIso8601String(),
            'updated-at'  => $resource->updated_at->toIso8601String(),
        ];
    }

    /**
     * @param \App\InvoiceItem $resource
     * @param bool             $isPrimary
     * @param array            $includeRelationships
     *
     * @return array
     */
    public function getRelationships($resource, $isPrimary, array $includeRelationships)
    {
        return [
            'comments' => [
                self::SHOW_SELF    => true,
                self::SHOW_RELATED => true,
            ],

            'invoice' => [
                self::SHOW_SELF    => true,
                self::SHOW_RELATED => true,
                self::SHOW_DATA    => isset($includeRelationships['invoice']),
                self::DATA         => function () use ($resource) {
                    return $resource->invoice;
                },
            ],
        ];
    }
}
