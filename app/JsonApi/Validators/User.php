<?php

namespace App\JsonApi\Validators;

use CloudCreativity\LaravelJsonApi\Contracts\Validators\RelationshipsValidatorInterface;
use CloudCreativity\LaravelJsonApi\Validators\AbstractValidatorProvider;

class User extends AbstractValidatorProvider
{
    /**
     * @var string
     */
    protected $resourceType = 'users';

    /**
     * Get the validation rules for the resource attributes.
     *
     * @param object|null $record
     *                            the record being updated, or null if it is a create request.
     *
     * @return array
     */
    protected function attributeRules($record = null)
    {
        return [
            'settings' => 'json',
        ];
    }

    /**
     * Define the validation rules for the resource relationships.
     *
     * @param RelationshipsValidatorInterface $relationships
     * @param object|null                     $record
     *                                                       the record being updated, or null if it is a create request.
     *
     * @return void
     */
    protected function relationshipRules(RelationshipsValidatorInterface $relationships, $record = null)
    {
        //
    }
}
