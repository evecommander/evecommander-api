<?php

namespace App;

use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * Class Role.
 *
 * @property string id
 * @property string owner_id
 * @property string owner_type
 * @property string name
 * @property string description
 * @property string created_by
 * @property string last_updated_by
 * @property Carbon created_at
 * @property Carbon updated_at
 *
 * Relationships
 * @property \Illuminate\Database\Eloquent\Collection owner
 * @property \Illuminate\Database\Eloquent\Collection permissions
 * @property \Illuminate\Database\Eloquent\Collection characters
 */
class Role extends Model
{
    use UuidTrait;

    /**
     * Get relation between this role and the organization that owns it.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function owner()
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
        return $this->belongsToMany(Permission::class)->withPivot(['created_at', 'updated_at']);
    }

    /**
     * Get relation between this role and any characters that are assigned to it.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function characters()
    {
        return $this->belongsToMany(Character::class)->withPivot(['created_at', 'updated_at']);
    }
}
