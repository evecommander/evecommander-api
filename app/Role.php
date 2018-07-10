<?php

namespace App;

use App\Abstracts\Organization;
use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * Class Role.
 *
 * @property string id
 * @property string organization_id
 * @property string organization_type
 * @property string name
 * @property string description
 * @property string created_by
 * @property string last_updated_by
 * @property Carbon created_at
 * @property Carbon updated_at
 *
 * Relationships
 * @property Organization organization
 * @property \Illuminate\Database\Eloquent\Collection permissions
 * @property \Illuminate\Database\Eloquent\Collection characters
 * @property \Illuminate\Database\Eloquent\Collection membershipLevels
 */
class Role extends Model
{
    use UuidTrait;

    /**
     * Get relation between this role and the organization that owns it.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function organization()
    {
        return $this->morphTo();
    }

    /**
     * Get relation between this role and any permissions it has access to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class)->withTimestamps();
    }

    /**
     * Get relation between this role and any characters that are assigned to it.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function characters()
    {
        return $this->belongsToMany(Character::class)->withTimestamps();
    }

    /**
     * Get relation between this role and any membership levels that are assigned to it.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function membershipLevels()
    {
        return $this->belongsToMany(MembershipLevel::class)->withTimestamps();
    }
}
