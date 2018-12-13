<?php

use CloudCreativity\LaravelJsonApi\Facades\JsonApi;
use CloudCreativity\LaravelJsonApi\Routing\ApiGroup;
use Illuminate\Contracts\Routing\Registrar;
use Illuminate\Support\Facades\Broadcast;
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

Broadcast::routes();

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::get('me', 'AuthController@me');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('characters/callback', 'Api\\CharacterController@callback')
        ->middleware('auth.callback');
    Route::get('characters/{character}/refresh', 'Api\\CharacterController@refreshToken')
        ->middleware('json-api.auth:default');

    JsonApi::register('v1', [
        'namespace'  => 'Api',
        'middleware' => 'json-api.auth:default',
    ], function (ApiGroup $api, Registrar $router) {
        $api->resource('users', [
            'except' => [
                'index',
                'create',
            ],
            'has-many' => [
                'characters',
                'notifications',
            ],
        ]);

        $api->resource('characters', [
            'controller' => true,
            'has-one'    => [
                'user'        => ['except' => 'replace'],
                'token'       => ['except' => 'replace', 'inverse' => 'oauth2-tokens'],
                'corporation' => ['except' => ['replace']],
            ],
            'has-many' => [
                'comments',
                'invoices',
                'notifications',
            ],
        ]);

        // All of these routes must have a X-Character header to tell what character is making the request
        Route::group(['middleware' => 'character'], function () use ($api) {
            $api->resource('corporations', [
                'has-one' => [
                    'defaultMembershipLevel',
                ],
                'has-many' => [
                    'handbooks',
                    'members',
                    'membershipLevels',
                    'memberships',
                    'alliance'   => ['except' => ['replace']],
                    'characters' => ['only' => ['related', 'read']],
                    'replacementClaims',
                    'invoices',
                    'receivedInvoices',
                    'notifications',
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
                    'coalition' => ['except' => ['replace']],
                    'replacementClaims',
                    'invoices',
                    'receivedInvoices',
                    'notifications',
                    'corporations' => ['only' => ['related', 'read']],
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
                    'replacementClaims',
                    'invoices',
                    'receivedInvoices',
                    'notifications',
                    'alliances' => ['only' => ['related', 'read']],
                ],
            ]);

            $api->resource('billing-conditions', [
                'has-one' => [
                    'organization',
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
                    'organization',
                    'billingCondition',
                ],
            ]);

            $api->resource('doctrines', [
                'has-one' => [
                    'organization',
                    'createdBy',
                    'lastUpdatedBy',
                ],
                'has-many' => [
                    'fittings',
                ],
            ]);

            $api->resource('fittings', [
                'has-one' => [
                    'organization',
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
                ],
            ]);

            $api->resource('fleet-types', [
                'has-one' => [
                    'organization',
                ],
                'has-many' => [
                    'fleets',
                ],
            ]);

            $api->resource('handbooks', [
                'has-one' => [
                    'organization',
                    'createdBy',
                    'lastUpdatedBy',
                ],
            ]);

            $api->resource('invoices', [
                'has-one' => [
                    'issuer',
                    'recipient',
                    'lastUpdatedBy',
                ],
                'has-many' => [
                    'items',
                    'payments',
                    'comments',
                    'notifications',
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
                ],
            ]);

            $api->resource('membership-fees', [
                'has-one' => [
                    'organization',
                ],
                'has-many' => [
                    'billingConditions',
                ],
            ]);

            $api->resource('membership-levels', [
                'has-one' => [
                    'organization',
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
                ],
            ]);

            $api->resource('roles', [
                'has-one' => [
                    'organization',
                ],
                'has-many' => [
                    'permissions',
                    'characters',
                    'membershipLevels',
                ],
            ]);

            $api->resource('rsvps', [
                'has-one' => [
                    'fleet',
                    'character',
                ],
            ]);

            $api->resource('subscriptions', [
                'has-one' => [
                    'character',
                    'organization',
                ],
            ]);
        });
    });
});
