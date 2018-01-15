<?php

namespace App;

use App\Traits\Commentable;
use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class ReplacementClaim extends Model
{
    use Commentable, Notifiable, UuidTrait;

    public $incrementing = false;

    public function character()
    {
        return $this->belongsTo(Character::class);
    }

    public function organization()
    {
        return $this->morphTo();
    }
}
