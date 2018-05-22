<?php

use CloudCreativity\LaravelJsonApi\Facades\JsonApi;
use CloudCreativity\LaravelJsonApi\Routing\ApiGroup;
use Illuminate\Contracts\Routing\Registrar;
use Illuminate\Support\Facades\Route;

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
Route::get('/', function () {
    return [];
});

Route::post('login', 'AuthController@login');

Route::group(['middleware' => 'auth'], function () {
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');

    Route::get('characters/callback', 'CharacterController@callback')
        ->middleware('auth.callback');
    Route::get('characters/{character}/refresh', 'CharacterController@refreshToken')
        ->middleware('json-api.auth:default');

    JsonApi::register('v1', ['namespace' => 'Api', 'middleware' => 'json-api.auth:default'], function (ApiGroup $api, Registrar $router) {
        $api->resource('users', [
            'has-many' => [
                'characters',
                'notifications',
                'readNotifications',
                'unreadNotifications',
            ],
        ]);

        $api->resource('characters', [
            'has-one' => [
                'user'  => ['except' => 'replace'],
                'token' => ['except' => 'replace'],
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
                'corporation',
            ],
        ]);

        $api->resource('corporations', [
            'has-one' => [
                'defaultMembershipLevel',
            ],
            'has-many' => [
                'handbooks',
                'members',
                'membershipLevels',
                'memberships',
                'alliance',
                'characters',
                'claims',
                'invoices',
                'fulfilledInvoices',
                'overdueInvoices',
                'pendingInvoices',
                'defaultInvoices',
                'issuedInvoices',
                'fulfilledIssuedInvoices',
                'overdueIssuedInvoices',
                'pendingIssuedInvoices',
                'defaultIssuedInvoices',
                'notifications',
                'readNotifications',
                'unreadNotifications',
            ],
        ]);

        $api->resource('alliances', [
            'has-one' => [
                'defaultMembershipLevel',
            ],
            'has-many' => [
                'handbooks',
                'members',
                'membershipLevels',
                'memberships',
                'coalition',
                'claims',
                'invoices',
                'fulfilledInvoices',
                'overdueInvoices',
                'pendingInvoices',
                'defaultInvoices',
                'issuedInvoices',
                'fulfilledIssuedInvoices',
                'overdueIssuedInvoices',
                'pendingIssuedInvoices',
                'defaultIssuedInvoices',
                'notifications',
                'readNotifications',
                'unreadNotifications',
                'corporations',
            ],
        ]);

        $api->resource('coalitions', [
            'has-one' => [
                'defaultMembershipLevel',
                'leader',
            ],
            'has-many' => [
                'handbooks',
                'members',
                'membershipLevels',
                'memberships',
                'claims',
                'invoices',
                'fulfilledInvoices',
                'overdueInvoices',
                'pendingInvoices',
                'defaultInvoices',
                'fulfilledInvoices',
                'overdueInvoices',
                'pendingInvoices',
                'defaultInvoices',
                'issuedInvoices',
                'fulfilledIssuedInvoices',
                'overdueIssuedInvoices',
                'pendingIssuedInvoices',
                'defaultIssuedInvoices',
                'notifications',
                'readNotifications',
                'unreadNotifications',
            ],
        ]);

        $api->resource('billing-conditions', [
            'has-one' => [
                'owner',
            ],
            'has-many' => [
                'discounts',
                'membershipFees',
            ],
        ]);

        $api->resource('comments', [
            'has-one' => [
                'character',
                'commentable',
            ],
            'has-many' => [
                'comments',
            ],
        ]);

        $api->resource('discounts', [
            'has-one' => [
                'owner',
                'billingCondition',
            ],
        ]);

        $api->resource('doctrines', [
            'has-one' => [
                'owner',
                'createdBy',
                'lastUpdatedBy',
            ],
            'has-many' => [
                'fittings',
            ],
        ]);

        $api->resource('fittings', [
            'has-one' => [
                'owner',
                'doctrine',
            ],
            'has-many' => [
                'replacementClaims',
            ],
        ]);

        $api->resource('fleets', [
            'has-one' => [
                'fleetType',
                'organization',
                'createdBy',
                'lastUpdatedBy',
            ],
            'has-many' => [
                'comments',
                'notifications',
                'readNotifications',
                'unreadNotifications',
            ],
        ]);

        $api->resource('fleet-types', [
            'has-one' => [
                'owner',
            ],
            'has-many' => [
                'fleets',
            ],
        ]);

        $api->resource('handbooks', [
            'has-one' => [
                'owner',
                'createdBy',
                'lastUpdatedBy',
            ],
        ]);

        $api->resource('invoices', [
            'has-one' => [
                'issuer',
                'recipient',
            ],
            'has-many' => [
                'items',
                'payments',
                'comments',
                'notifications',
                'readNotifications',
                'unreadNotifications',
            ],
        ]);

        $api->resource('invoice-items', [
            'has-one' => [
                'invoice',
            ],
            'has-many' => [
                'comments',
            ],
        ]);

        $api->resource('memberships', [
            'has-one' => [
                'membershipLevel',
                'organization',
                'member',
                'createdBy',
                'lastUpdatedBy',
            ],
            'has-many' => [
                'notifications',
                'readNotifications',
                'unreadNotifications',
            ],
        ]);

        $api->resource('membership-fees', [
            'has-one' => [
                'owner',
            ],
            'has-many' => [
                'billingConditions',
            ],
        ]);

        $api->resource('membership-levels', [
            'has-one' => [
                'owner',
                'createdBy',
                'lastUpdatedBy',
            ],
            'has-many' => [
                'memberships',
            ],
        ]);

        $api->resource('permissions', [
            'has-many' => [
                'membershipLevels',
            ],
        ]);

        $api->resource('replacement-claims', [
            'has-one' => [
                'character',
                'organization',
            ],
            'has-many' => [
                'comments',
                'notifications',
                'readNotifications',
                'unreadNotifications',
            ],
        ]);
    });
});
