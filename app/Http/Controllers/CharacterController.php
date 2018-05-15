<?php

namespace App\Http\Controllers;

use App\Character;
use App\OAuth2Token;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CharacterController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return
     */
    public function callback(Request $request)
    {
        $token = new OAuth2Token;
        $token->access_token = $request->get('access_token');
        $token->refresh_token = $request->get('refresh_token');
        $token->expires_on = $request->get('expires_on');

        $character = new Character;
        $character->eve_id = $request->get('id');
        $character->name = $request->get('name');
        $character->user()->associate(Auth::user());
        $character->token()->associate($token);

        broadcast();
    }
}
