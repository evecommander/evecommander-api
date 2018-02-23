<?php

namespace App;

use App\Traits\IsMember;
use App\Traits\ReceivesInvoices;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class Character extends Model
{
    use IsMember, ReceivesInvoices;

    /**
     * Get all subscribers for invoice events
     *
     * @return Collection
     */
    public function receivedInvoiceSubscribers()
    {
        return collect($this->user());
    }

    /**
     * Get the user that this character belongs to
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all comments belonging to the character
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
