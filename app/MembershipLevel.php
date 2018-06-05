<?php

namespace App;

use App\Abstracts\Organization;
use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * Class MembershipLevel.
 *
 * @property string id
 * @property string organization_id
 * @property string organization_type
 * @property string name
 * @property string description
 * @property float dues
 * @property string dues_structure
 * @property string created_by
 * @property string updated_by
 * @property Carbon created_at
 * @property Carbon updated_at
 *
 * Relationships
 * @property \Illuminate\Database\Eloquent\Collection memberships
 * @property Organization organization
 * @property Character createdBy
 * @property Character lastUpdatedBy
 * @property \Illuminate\Database\Eloquent\Collection permissions
 */
class MembershipLevel extends Model
{
    use UuidTrait;

    const DUES_STRUCTURE_PER_DAY = 'per_day';
    const DUES_STRUCTURE_PER_WEEK = 'per_week';
    const DUES_STRUCTURE_PER_MONTH = 'per_month';
    const DUES_STRUCTURE_PER_QUARTER = 'per_quarter';
    const DUES_STRUCTURE_PER_HALF = 'per_half';
    const DUES_STRUCTURE_PER_YEAR = 'per_year';
    const DUES_STRUCTURE_UPON_JOINING = 'upon_joining';

    /**
     * Get relation between this membership level and any memberships that belong to it.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function memberships()
    {
        return $this->hasMany(Membership::class);
    }

    /**
     * Get relation between this membership level and the organization that owns it.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function organization()
    {
        return $this->morphTo();
    }

    /**
     * Get relation between this membership level and the character that created it.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function createdBy()
    {
        return $this->belongsTo(Character::class, 'created_by');
    }

    /**
     * Get relation between this membership level and the character that last updated it.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function lastUpdatedBy()
    {
        return $this->belongsTo(Character::class, 'last_updated_by');
    }

    /**
     * Get relation between this membership level and any permissions that are assigned to it.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }
}
