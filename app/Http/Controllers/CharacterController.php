<?php

namespace App\Http\Controllers;

use App\Character;
use App\Jobs\ProcessAuthCallback;
use App\Jobs\ProcessTokenRefresh;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CharacterController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return
     */
    public function callback(Request $request)
    {
        $user = Auth::user();
        ProcessAuthCallback::dispatch($user, $request->get('code'));
    }

    /**
     * Refresh a Character's OAuth2 Token and broadcast it back to them.
     *
     * @param Request   $request
     * @param Character $character
     */
    public function refreshToken(Request $request, Character $character)
    {
        $user = Auth::user();
        ProcessTokenRefresh::dispatch($user, $character);
    }
}
