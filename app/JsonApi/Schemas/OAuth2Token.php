<?php

namespace App\JsonApi\Schemas;

use CloudCreativity\LaravelJsonApi\Eloquent\AbstractSchema;

class OAuth2Token extends AbstractSchema
{

    /**
     * @var string
     */
    protected $resourceType = 'o-auth2-tokens';

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

