<?php

namespace App\Contracts;

interface HasFleetTypesContract
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function fleetTypes();
}