<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

trait UuidTrait
{
    public $incrementing = false;

    protected static function boot ()
    {
        parent::boot();

        static::creating(function (Model $model) {
            $uuid = Uuid::uuid5(Uuid::NAMESPACE_DNS, env('UUID_NAMESPACE_DNS', 'api.srv'));

            $model->attributes[$model->getKeyName()] = $uuid->getHex();
        });
    }
}