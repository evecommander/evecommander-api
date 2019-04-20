<?php

namespace App\JsonApi\Schemas;

use Neomerx\JsonApi\Schema\SchemaProvider;

class BillingConditionGroupSchema extends SchemaProvider
{

    /**
     * @var string
     */
    protected $resourceType = 'billing-condition-groups';

    /**
     * @param \App\BillingConditionGroup $resource
     *      the domain record being serialized.
     * @return string
     */
    public function getId($resource)
    {
        return (string) $resource->getRouteKey();
    }

    /**
     * @param \App\BillingConditionGroup $resource
     *      the domain record being serialized.
     * @return array
     */
    public function getAttributes($resource)
    {
        return [
            'created-at' => $resource->created_at->toAtomString(),
            'updated-at' => $resource->updated_at->toAtomString(),
        ];
    }

    /**
     * @param \App\BillingConditionGroup $resource
     * @param bool                       $isPrimary
     * @param array                      $includeRelationships
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

            'membership-fees' => [
                self::SHOW_SELF    => true,
                self::SHOW_RELATED => true,
                self::META         => function () use ($resource) {
                    return [
                        'count' => $resource->membershipFees->count(),
                    ];
                },
            ],

            'billing-conditions' => [
                self::SHOW_SELF    => true,
                self::SHOW_RELATED => true,
                self::META         => function () use ($resource) {
                    return [
                        'count' => $resource->billingConditions->count(),
                    ];
                },
            ],

            'child-groups' => [
                self::SHOW_SELF    => true,
                self::SHOW_RELATED => true,
                self::META         => function () use ($resource) {
                    return [
                        'count' => $resource->billingConditions->count(),
                    ];
                },
            ],

            'parent-group' => [
                self::SHOW_SELF    => true,
                self::SHOW_RELATED => true,
                self::SHOW_DATA    => isset($includeRelationships['billing-condition-group']),
                self::DATA         => function () use ($resource) {
                    return $resource->parentGroup;
                },
            ]
        ];
    }
}
