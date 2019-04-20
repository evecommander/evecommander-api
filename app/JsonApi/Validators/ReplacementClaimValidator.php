<?php

namespace App\JsonApi\Validators;

use App\ReplacementClaim;
use CloudCreativity\LaravelJsonApi\Validation\AbstractValidators;
use Illuminate\Validation\Rule;

class ReplacementClaimValidator extends AbstractValidators
{
    /**
     * @var string
     */
    protected $resourceType = 'replacement-claims';

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
        'status',
        'created-at',
        'updated-at',
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
            'killmail-id'   => 'required|string',
            'killmail-hash' => 'required|string',
            'status'        => [
                'required',
                'string',
                Rule::in(ReplacementClaim::AVAILABLE_STATUSES),
            ],
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
