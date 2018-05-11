<?php

namespace App\Http\Controllers;

use App\Character;
use App\Http\Resources\CharacterResource;
use App\Http\Resources\CharactersResource;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CharacterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return array
     */
    public function index()
    {
        /** @var User $user */
        $user = Auth::user();
        return (new CharactersResource($user->characters->paginate()));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return CharacterResource
     */
    public function callback(Request $request)
    {
        $character = new Character;

        $character->id = $request->id;
        $character->name = $request->name;
        $character->refresh_token = $request->refresh_token;
        $character->user()->associate(Auth::user());

        return $this->show($character);
    }

    /**
     * Display the specified resource.
     *
     * @param  Character $character
     * @return CharacterResource
     */
    public function show(Character $character)
    {
        CharacterResource::withoutWrapping();

        return new CharacterResource($character);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Character $character
     * @return CharacterResource
     */
    public function update(Request $request, Character $character)
    {
        $character->refresh_token = $request->refresh_token;

        CharacterResource::withoutWrapping();

        return new CharacterResource($character);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Character $character
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Character $character)
    {
        $character->delete();

        return response('Character deleted', 204);
    }
}
