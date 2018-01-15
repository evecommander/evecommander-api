<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Membership extends Model
{
    use Notifiable;

    public function level()
    {
        return $this->belongsTo(MembershipLevel::class);
    }

    public function owner()
    {
        return $this->morphTo();
    }

    public function member()
    {
        return $this->morphTo();
    }

    public function addedBy()
    {
        return $this->belongsTo(Character::class, 'added_by');
    }

    public function lastUpdatedBy()
    {
        return $this->belongsTo(Character::class, 'last_updated_by');
    }
}
