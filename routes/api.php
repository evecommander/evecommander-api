<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use CloudCreativity\LaravelJsonApi\Facades\JsonApi;
use CloudCreativity\LaravelJsonApi\Routing\ApiGroup;
use Illuminate\Contracts\Routing\Registrar;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('auth/callback', 'CharacterController@callback');

Route::apiResource('characters', 'CharacterController');

JsonApi::register('v1', ['namespace' => 'Api', 'middleware' => 'json-api.auth:default'], function (ApiGroup $api, Registrar $router) {
    $api->resource('users', [
        'has-many' => [
            'characters',
            'notifications',
            'readNotifications',
            'unreadNotifications',
        ]
    ]);

    $api->resource('characters', [
        'has-one' => [
            'user' => ['except' => 'replace'],
            'token' => ['except' => 'replace']
        ],
        'has-many' => [
            'comments',
            'invoices',
            'fulfilledInvoices',
            'overdueInvoices',
            'pendingInvoices',
            'defaultInvoices',
            'notifications',
            'readNotifications',
            'unreadNotifications',
        ]
    ]);

    $api->resource('corporations', [

    ]);
});
