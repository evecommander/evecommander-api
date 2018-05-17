<?php

namespace App\Traits;

use App\Comment;

/**
 * Trait HasComments.
 *
 * @method morphMany(string $related, string $name)
 */
trait HasComments
{
    /**
     * Get any comments attached to the model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}
