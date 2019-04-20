<?php

namespace App\JsonApi\Schemas;

use Neomerx\JsonApi\Schema\SchemaProvider;

class BillingConditionSchema extends SchemaProvider
{
    /**
     * @var string
     */
    protected $resourceType = 'billing-conditions';

    /**
     * @param \App\BillingCondition $resource
     *                                        the domain record being serialized.
     *
     * @return string
     */
    public function getId($resource)
    {
        return (string) $resource->getRouteKey();
    }

    /**
     * @param \App\BillingCondition $resource
     *                                        the domain record being serialized.
     *
     * @return array
     */
    public function getAttributes($resource)
    {
        return [
            'name'        => $resource->name,
            'description' => $resource->description,
            'type'        => $resource->type,
            'quantity'    => $resource->quantity,
            'created-at'  => $resource->created_at->toIso8601String(),
            'updated-at'  => $resource->updated_at->toIso8601String(),
        ];
    }

    /**
     * @param \App\BillingCondition $resource
     * @param bool                  $isPrimary
     * @param array                 $includeRelationships
     *
     * @return array
     */
    public function getRelationships($resource, $isPrimary, array $includeRelationships)
    {
        return [
            'organization' => [
                self::SHOW_SELF    => true,
                self::SHOW_RELATED => true,
                self::SHOW_DATA    => true,
                self::DATA         => function () use ($resource) {
                    return $resource->organization;
                },
            ],

            'discounts' => [
                self::SHOW_SELF    => true,
                self::SHOW_RELATED => true,
                self::META         => function () use ($resource) {
                    return [
                        'count' => $resource->discounts->count(),
                    ];
                },
            ],

            'membership-fees' => [
                self::SHOW_SELF    => true,
                self::SHOW_RELATED => true,
                self::META         => function () use ($resource) {
                    return [
                        'count' => $resource->membershipFees->count(),
                    ];
                },
            ],

            'billing-condition-group' => [
                self::SHOW_SELF    => true,
                self::SHOW_RELATED => true,
                self::SHOW_DATA    => isset($includeRelationships['billing-condition-group']),
                self::DATA         => function () use ($resource) {
                    return $resource->billingConditionGroup;
                },
            ],
        ];
    }
}
