<?php

namespace App;

use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * Class Permission
 *
 * @property string id
 * @property string name
 * @property string description
 * @property string slug
 * @property Carbon created_at
 * @property Carbon updated_at
 *
 * Relationships
 * \Illuminate\Database\Eloquent\Relations\BelongsToMany membershipLevels
 */
class Permission extends Model
{
    use UuidTrait;

    /**
     * Get relation between this permission and any membership levels that belong to it.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function membershipLevels()
    {
        return $this->belongsToMany(MembershipLevel::class);
    }
}
