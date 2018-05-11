<?php

namespace App;

use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * Class MembershipLevel
 *
 * @property string id
 * @property string owner_id
 * @property string owner_type
 * @property string name
 * @property string description
 * @property double dues
 * @property string dues_structure
 * @property string created_by
 * @property string updated_by
 * @property Carbon created_at
 * @property Carbon updated_at
 */
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
