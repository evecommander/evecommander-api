<?php

namespace App\Traits;

use App\Comment;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * Trait Commentable
 * @package App\Traits
 *
 * @method morphMany(string $related, string $name)
 */
trait Commentable
{
    /**
     * Get any comments attached to the model
     *
     * @return MorphMany
     */
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}