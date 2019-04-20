<?php

namespace App\JsonApi\Validators;

use App\Fleet;
use CloudCreativity\LaravelJsonApi\Rules\DateTimeIso8601;
use CloudCreativity\LaravelJsonApi\Validation\AbstractValidators;
use Illuminate\Validation\Rule;

class FleetValidator extends AbstractValidators
{
    /**
     * @var string
     */
    protected $resourceType = 'fleets';

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
        'start-at',
        'end-at',
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
            'name'        => 'nullable|array',
            'description' => 'string',
            'status'      => [
                'string',
                Rule::in(Fleet::AVAILABLE_STATUSES),
            ],
            'start-at' => new DateTimeIso8601(),
            'end-at'   => [
                'nullable',
                new DateTimeIso8601(),
            ],
            'track-history' => 'required|boolean',
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
