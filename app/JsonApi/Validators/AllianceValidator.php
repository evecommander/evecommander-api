<?php

namespace App\JsonApi\Validators;

use CloudCreativity\LaravelJsonApi\Contracts\Validators\RelationshipsValidatorInterface;
use CloudCreativity\LaravelJsonApi\Validators\AbstractValidatorProvider;

class AllianceValidator extends AbstractValidatorProvider
{
    /**
     * @var string
     */
    protected $resourceType = 'alliances';

    /**
     * Get the validation rules for the resource attributes.
     *
     * @param $record
     *      the record being updated, or null if it is a create request.
     *
     * @return array
     */
    protected function attributeRules($record = null)
    {
        return [
            //
        ];
    }

    /**
     * Define the validation rules for the resource relationships.
     *
     * @param RelationshipsValidatorInterface $relationships
     * @param $record
     *      the record being updated, or null if it is a create request.
     *
     * @return void
     */
    protected function relationshipRules(RelationshipsValidatorInterface $relationships, $record = null)
    {
        //
    }
}
