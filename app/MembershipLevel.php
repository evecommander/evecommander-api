<?php

namespace App;

use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;

class MembershipLevel extends Model
{
    use UuidTrait;

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

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    public function hasPermission(string $permission_slug)
    {
        return $this->permissions()->where('slug', $permission_slug)->exists();
    }
}
