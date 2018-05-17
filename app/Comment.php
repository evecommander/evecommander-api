<?php

namespace App;

use App\Traits\HasComments;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Comment.
 *
 * @property string id
 * @property string commentable_id
 * @property string commentable_type
 * @property string character_id
 * @property string text
 * @property Carbon created_at
 * @property Carbon updated_at
 *
 * Relationships
 * @property \Illuminate\Database\Eloquent\Relations\MorphMany comments
 * @property \Illuminate\Database\Eloquent\Relations\BelongsTo character
 * @property \Illuminate\Database\Eloquent\Relations\MorphTo commentable
 */
class Comment extends Model
{
    use HasComments;

    /**
     * Get the character that authored the comment.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function character()
    {
        return $this->belongsTo(Character::class);
    }

    /**
     * Get the owning commentable model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function commentable()
    {
        return $this->morphTo();
    }
}
