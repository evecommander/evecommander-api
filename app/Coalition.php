<?php

namespace App;

use App\Abstracts\Organization;
use Illuminate\Support\Carbon;

/**
 * Class Coalition.
 *
 * @property string id
 * @property int leader_character_id
 * @property string name
 * @property string description
 * @property string logo
 * @property string default_membership_level
 * @property array settings
 * @property Carbon created_at
 * @property Carbon updated_at
 *
 * Relationships
 * @property Character leader
 * @property \Illuminate\Database\Eloquent\Collection alliances
 */
class Coalition extends Organization
{
    protected $casts = [
        'settings' => 'array',
    ];

    /**
     * Get relation between this coalition and the character that is designated as the leader.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function leader()
    {
        return $this->belongsTo(Character::class, 'leader_character_id');
    }

    /**
     * Get relation between this coalition and any alliances that are members of it.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function alliances()
    {
        return $this->members()->where('member_type', Alliance::class)->with('member');
    }
}
