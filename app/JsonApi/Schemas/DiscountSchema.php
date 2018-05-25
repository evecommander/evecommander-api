<?php

namespace App\JsonApi\Schemas;

use Neomerx\JsonApi\Schema\SchemaProvider;

class DiscountSchema extends SchemaProvider
{
    /**
     * @var string
     */
    protected $resourceType = 'discounts';

    /**
     * @param \App\Discount $resource
     *                                the domain record being serialized.
     *
     * @return string
     */
    public function getId($resource)
    {
        return (string) $resource->getKey();
    }

    /**
     * @param \App\Discount $resource
     *                                the domain record being serialized.
     *
     * @return array
     */
    public function getAttributes($resource)
    {
        return [
            'amount-type' => $resource->amount_type,
            'amount'      => $resource->amount,
            'created-at'  => $resource->created_at->toIso8601String(),
            'updated-at'  => $resource->updated_at->toIso8601String(),
        ];
    }

    /**
     * @param \App\Discount $resource
     * @param bool          $isPrimary
     * @param array         $includeRelationships
     *
     * @return array
     */
    public function getRelationships($resource, $isPrimary, array $includeRelationships)
    {
        return [
            'organization' => [
                self::SHOW_SELF    => true,
                self::SHOW_RELATED => true,
                self::SHOW_DATA    => isset($includeRelationships['organization']),
                self::DATA         => function () use ($resource) {
                    return $resource->organization;
                },
            ],

            'billingCondition' => [
                self::SHOW_SELF    => true,
                self::SHOW_RELATED => true,
                self::SHOW_DATA    => isset($includeRelationships['billing-condition']),
                self::DATA         => function () use ($resource) {
                    return $resource->billingCondition;
                },
            ],
        ];
    }
}
