<?php

namespace App;

use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use UuidTrait;

    public $incrementing = false;

    protected $casts = [
        'value' => 'array'
    ];

    public function owner()
    {
        return $this->morphTo();
    }
}
