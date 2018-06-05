<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

trait UuidTrait
{
    protected static function boot()
    {
        parent::boot();

        static::creating(function (Model $model) {
            if (method_exists(static::class, 'onCreate')) {
                static::onCreate($model);
            }

            if ($model->{$model->getKeyName()}) {
                return;
            }

            $model->{$model->getKeyName()} = Uuid::uuid5(Uuid::NAMESPACE_DNS, env('UUID_NAMESPACE_DNS'))->getHex();
        });
    }

    public function getIncrementing()
    {
        return false;
    }
}
