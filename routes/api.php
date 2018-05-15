<?php

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

Route::post('login', 'AuthController@login');
Route::post('logout', 'AuthController@logout');
Route::post('refresh', 'AuthController@refresh');
Route::post('me', 'AuthController@me');

Route::get('auth/callback', 'CharacterController@callback')->middleware('auth.callback');

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

    $api->resource('alliances', [

    ]);

    $api->resource('coalitions', [

    ]);

    $api->resource('billing-conditions', [

    ]);

    $api->resource('comments', [

    ]);

    $api->resource('discounts', [

    ]);

    $api->resource('doctrines', [

    ]);

    $api->resource('fittings', [

    ]);

    $api->resource('fleets', [

    ]);

    $api->resource('fleet-types', [

    ]);

    $api->resource('handbooks', [

    ]);

    $api->resource('invoices', [

    ]);

    $api->resource('invoice-items', [

    ]);

    $api->resource('memberships', [

    ]);

    $api->resource('membership-fees', [

    ]);

    $api->resource('membership-levels', [

    ]);

    $api->resource('permissions', [

    ]);

    $api->resource('replacement-claims', [

    ]);
});
