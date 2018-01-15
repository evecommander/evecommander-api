<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Handbook extends Model
{
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

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}
