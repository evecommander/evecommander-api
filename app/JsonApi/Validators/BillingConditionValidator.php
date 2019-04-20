<?php

namespace App\JsonApi\Validators;

use App\BillingCondition;
use CloudCreativity\LaravelJsonApi\Validation\AbstractValidators;
use Illuminate\Validation\Rule;

class BillingConditionValidator extends AbstractValidators
{
    /**
     * @var string
     */
    protected $resourceType = 'billing-conditions';

    /**
     * The include paths a client is allowed to request.
     *
     * @var string[]|null
     *                    the allowed paths, an empty array for none allowed, or null to allow all paths.
     */
    protected $allowedIncludePaths = null;

    /**
     * The sort field names a client is allowed send.
     *
     * @var string[]|null
     *                    the allowed fields, an empty array for none allowed, or null to allow all fields.
     */
    protected $allowedSortParameters = [
        'name',
        'created-at',
        'updated-at',
        'type',
    ];

    /**
     * Get resource validation rules.
     *
     * @param mixed|null $record
     *                           the record being updated, or null if creating a resource.
     *
     * @return array
     */
    protected function rules($record = null): array
    {
        return [
            'name'        => 'required|string',
            'description' => 'string',
            'type'        => [
                'required',
                Rule::in(BillingCondition::ALLOWED_TYPES),
            ],
            'quantity' => 'required|integer',
        ];
    }

    /**
     * Get query parameter validation rules.
     *
     * @return array
     */
    protected function queryRules(): array
    {
        return [
            //
        ];
    }
}
