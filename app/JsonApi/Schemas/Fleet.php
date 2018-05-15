<?php

namespace App\JsonApi\Schemas;

use CloudCreativity\LaravelJsonApi\Eloquent\AbstractSchema;

class Fleet extends AbstractSchema
{

    /**
     * @var string
     */
    protected $resourceType = 'fleets';

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
