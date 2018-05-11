<?php

namespace App\JsonApi\Schemas;

use CloudCreativity\LaravelJsonApi\Eloquent\AbstractSchema;

class BillingCondition extends AbstractSchema
{

    /**
     * @var string
     */
    protected $resourceType = 'billing-conditions';

    /**
     * Model attributes to serialize.
     *
     * @var array|null
     */
    protected $attributes = null;

    /**
     * Model relationships to serialize.
     *
     * @var array
     */
    protected $relationships = [];

}

