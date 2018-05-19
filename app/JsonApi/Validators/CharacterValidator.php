<?php

namespace App\JsonApi\Validators;

use CloudCreativity\LaravelJsonApi\Contracts\Validators\RelationshipsValidatorInterface;
use CloudCreativity\LaravelJsonApi\Validators\AbstractValidatorProvider;

class CharacterValidator extends AbstractValidatorProvider
{
    /**
     * @var string
     */
    protected $resourceType = 'characters';

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
            //
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
        $relationships->hasOne('user', 'users', true);
        $relationships->hasOne('token', 'oauth2-tokens', true);
        $relationships->hasMany('comments', 'comments');
        $relationships->hasMany('memberships', 'memberships');
        $relationships->hasMany('invoices', 'invoices');
        $relationships->hasMany('fulfilledInvoices', 'invoices');
        $relationships->hasMany('overdueInvoices', 'invoices');
        $relationships->hasMany('pendingInvoices', 'invoices');
        $relationships->hasMany('defaultInvoices', 'invoices');
        $relationships->hasMany('notifications', 'notifications');
        $relationships->hasMany('readNotifications', 'notifications');
        $relationships->hasMany('unreadNotifications', 'notifications');
    }
}
