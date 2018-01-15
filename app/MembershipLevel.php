<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MembershipLevel extends Model
{
    public function memberships()
    {
        return $this->hasMany(Membership::class);
    }

    public function owner()
    {
        return $this->morphTo();
    }

    public function createdBy()
    {
        return $this->belongsTo(Character::class, 'created_by');
    }

    public function lastUpdatedBy()
    {
        return $this->belongsTo(Character::class, 'last_updated_by');
    }
}
