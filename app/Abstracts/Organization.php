<?php

namespace App\Abstracts;

use App\FleetType;
use App\Traits\HasHandbooks;
use App\Traits\HasMembers;
use App\Traits\IsMember;
use Illuminate\Database\Eloquent\Model;

abstract class Organization extends Model
{
    use HasHandbooks, HasMembers, IsMember;

    /**
     * Get relation between this organization and any fleet types it owns.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function fleetTypes()
    {
        return $this->morphMany(FleetType::class, 'owner');
    }
}