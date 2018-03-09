<?php

namespace App\Http\Controllers;

use App\Character;
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
        return [
            'characters' => Auth::user()->characters()
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function callback(Request $request)
    {
        $character = new Character;

        $character->id = $request->id;
        $character->name = $request->name;
        $character->refresh_token = $request->refresh_token;
        $character->user()->associate(Auth::user());

        return redirect()->route('characters.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  Character $character
     * @return array
     */
    public function show(Character $character)
    {
        return [
            'character' => $character
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Character $character
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Character $character)
    {
        $character->refresh_token = $request->refresh_token;

        return response('Character Updated', 200);
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
