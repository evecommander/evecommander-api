<?php

namespace App\JsonApi\Schemas;

use Neomerx\JsonApi\Schema\SchemaProvider;

class BillingCondition extends SchemaProvider
{

    /**
     * @var string
     */
    protected $resourceType = 'billing-conditions';

    /**
     * @param \App\BillingCondition $resource
     *      the domain record being serialized.
     * @return string
     */
    public function getId($resource)
    {
        return (string) $resource->getKey();
    }

    /**
     * @param \App\BillingCondition $resource
     *      the domain record being serialized.
     * @return array
     */
    public function getAttributes($resource)
    {
        return [
            'name' => $resource->name,
            'description' => $resource->description,
            'type' => $resource->type,
            'quantity' => $resource->quantity,
            'created-at' => $resource->created_at->toIso8601String(),
            'updated-at' => $resource->updated_at->toIso8601String(),
        ];
    }

    /**
     * @param \App\BillingCondition $resource
     * @param bool $isPrimary
     * @param array $includeRelationships
     * @return array
     */
    public function getRelationships($resource, $isPrimary, array $includeRelationships)
    {
        return [
            'owner' => [
                self::SHOW_SELF => true,
                self::SHOW_RELATED => true,
                self::SHOW_DATA => true,
            ],

            'discounts' => [
                self::SHOW_SELF => true,
                self::SHOW_RELATED => true,
            ],

            'membership-fees' => [
                self::SHOW_SELF => true,
                self::SHOW_RELATED => true,
            ]
        ];
    }

}

