<?php

namespace App;

use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * Class MembershipLevel.
 *
 * @property string id
 * @property string owner_id
 * @property string owner_type
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
 * @property \Illuminate\Database\Eloquent\Relations\HasMany memberships
 * @property \Illuminate\Database\Eloquent\Relations\MorphTo owner
 * @property \Illuminate\Database\Eloquent\Relations\BelongsTo createdBy
 * @property \Illuminate\Database\Eloquent\Relations\BelongsTo lastUpdatedBy
 * @property \Illuminate\Database\Eloquent\Relations\BelongsToMany permissions
 */
class MembershipLevel extends Model
{
    use UuidTrait;

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
     * Get relation between this membership level and it's owner.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function owner()
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
