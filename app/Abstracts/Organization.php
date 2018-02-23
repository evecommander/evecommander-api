<?php

namespace App\Abstracts;

use App\Traits\HasHandbooks;
use App\Traits\HasMembers;
use App\Traits\IsMember;
use Illuminate\Database\Eloquent\Model;

abstract class Organization extends Model
{
    use HasHandbooks;
    use HasMembers;
    use IsMember;

    public $incrementing = false;
}