<?php

namespace App;

use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;

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
