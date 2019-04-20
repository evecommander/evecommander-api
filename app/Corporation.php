<?php

namespace App;

use App\Abstracts\Organization;
use Illuminate\Support\Carbon;

/**
 * Class Corporation.
 *
 * @property string id
 * @property int api_id
 * @property string name
 * @property string default_membership_level_id
 * @property array settings
 * @property Carbon created_at
 * @property Carbon updated_at
 *
 * Relationships
 * @property Alliance alliance
 * @property \Illuminate\Database\Eloquent\Collection characters
 */
class Corporation extends Organization
{
    protected $casts = [
        'settings' => 'array',
    ];

    /**
     * Get relationship between this corporation and the alliance it belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function alliance()
    {
        return $this->memberships()->where('organization_type', Alliance::class)->with('organization');
    }

    /**
     * Get relation between this corporation and any characters that belong to it.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function characters()
    {
        return $this->members()->where('member_type', Character::class)->with('member');
    }
}
