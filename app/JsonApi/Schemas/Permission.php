<?php

namespace App\JsonApi\Schemas;

use CloudCreativity\LaravelJsonApi\Eloquent\AbstractSchema;

class Permission extends AbstractSchema
{

    /**
     * @var string
     */
    protected $resourceType = 'permissions';

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

