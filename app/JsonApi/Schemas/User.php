<?php

namespace App\JsonApi\Schemas;

use CloudCreativity\LaravelJsonApi\Eloquent\AbstractSchema;

class User extends AbstractSchema
{

    /**
     * @var string
     */
    protected $resourceType = 'users';

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
    protected $relationships = [
        'characters',
        'notifications',
        'readNotifications',
        'unreadNotifications',
    ];

}

