<?php

namespace App\JsonApi\Validators;

use App\Invoice;
use CloudCreativity\LaravelJsonApi\Rules\DateTimeIso8601;
use CloudCreativity\LaravelJsonApi\Validation\AbstractValidators;
use Illuminate\Validation\Rule;

class InvoiceValidator extends AbstractValidators
{
    /**
     * @var string
     */
    protected $resourceType = 'invoices';

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
        'due-date',
        'hard-due-date',
        'status',
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
            'name'   => 'required|string',
            'status' => [
                'string',
                Rule::in(Invoice::AVAILABLE_STATES),
            ],
            'due-date'      => new DateTimeIso8601(),
            'hard-due-date' => new DateTimeIso8601(),
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
