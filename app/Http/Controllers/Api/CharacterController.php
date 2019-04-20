<?php

namespace App\Http\Controllers\Api;

use App\Character;
use App\Jobs\ProcessAuthCallback;
use App\Jobs\ProcessTokenRefresh;
use CloudCreativity\LaravelJsonApi\Contracts\Queue\AsynchronousProcess;
use CloudCreativity\LaravelJsonApi\Http\Controllers\JsonApiController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CharacterController extends JsonApiController
{
    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return Response
     */
    public function callback(Request $request)
    {
        ProcessAuthCallback::dispatch($request->user(), $request->get('code'));

        return response()->make("Importing character now.\nYou may close this tab now.", 202);
    }

    /**
     * Refresh a Character's OAuth2 Token and broadcast it back to them.
     *
     * @param Request   $request
     * @param Character $character
     *
     * @return AsynchronousProcess
     */
    public function refreshToken(Request $request, Character $character)
    {
        return ProcessTokenRefresh::client($request->user(), $character)->dispatch();
    }
}
