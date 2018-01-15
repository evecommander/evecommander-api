<?php

namespace App\Traits;

use App\Comment;

/**
 * Trait Commentable
 * @package App\Traits
 *
 * @method morphMany(string $related, string $name)
 */
trait Commentable
{

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}