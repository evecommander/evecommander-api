<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function formatValidationErrors(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $status = 422;

        return [
            'message' => $status.' error',
            'errors'  => [
                'message' => $validator->getMessageBag()->first(),
                'info'    => [$validator->getMessageBag()->keys()[0]],
            ],
            'status_code' => $status,
        ];
    }
}
