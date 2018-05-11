<?php

namespace App;

use App\Traits\Commentable;
use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class ReplacementClaim extends Model
{
    use Commentable, Notifiable, UuidTrait;

    /**
     * Get Character that this ReplacementClaim belongs to
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function character()
    {
        return $this->belongsTo(Character::class);
    }

    /**
     * Get Organization that this ReplacementClaim belongs to
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function organization()
    {
        return $this->morphTo();
    }
}
