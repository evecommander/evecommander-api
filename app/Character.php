<?php

namespace App;

use App\Traits\IsMember;
use App\Traits\ReceivesInvoices;
use Illuminate\Database\Eloquent\Model;

class Character extends Model
{
    use IsMember, ReceivesInvoices;

    public function receivedInvoiceSubscribers()
    {
        return [$this->user()];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
