<?php

namespace App\Contracts;

interface HasCommentsContract
{
    /**
     * Get any comments attached to the model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function comments();
}