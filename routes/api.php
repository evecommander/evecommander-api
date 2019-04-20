<?php

use CloudCreativity\LaravelJsonApi\Facades\JsonApi;
use CloudCreativity\LaravelJsonApi\Routing\RelationshipsRegistration;
use CloudCreativity\LaravelJsonApi\Routing\RouteRegistrar;
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

Route::post('/users/forgot-password', 'Api\\UserController@sendResetLinkEmail');

Route::post('/users/reset-password', 'Api\\UserController@reset');

Route::get('characters/callback', 'Api\\CharacterController@callback')
    ->middleware('auth.callback');

Route::get('me', 'AuthController@me')->middleware('auth:api');

JsonApi::register('v1', [
    'namespace'  => 'Api',
    'middleware' => 'json-api.auth:default',
], function (RouteRegistrar $api) {
    $api->resource('users')
        ->controller()
        ->except('index')
        ->relationships(function (RelationshipsRegistration $relations) {
            $relations->hasMany('characters');
            $relations->hasMany('notifications');
        });

    Route::group(['middleware' => 'auth:api'], function () use ($api) {
        $api->resource('characters')
            ->controller()
            ->relationships(function (RelationshipsRegistration $relations) {
                $relations->hasOne('user')->except('replace');
                $relations->hasOne('token', 'oauth2-tokens')->except('replace');
                $relations->hasOne('corporation')->readOnly();

                $relations->hasMany('comments');
                $relations->hasMany('invoices');
                $relations->hasMany('notifications');
                $relations->hasMany('memberships');
            });

        // All of these routes must have a X-Character header to tell what character is making the request
        Route::group(['middleware' => 'character'], function () use ($api) {
            $api->resource('corporations')
                ->relationships(function (RelationshipsRegistration $relations) {
                    $relations->hasOne('default-membership-level', 'membership-levels');

                    $relations->hasMany('handbooks');
                    $relations->hasMany('members', 'memberships');
                    $relations->hasMany('membership-levels');
                    $relations->hasMany('memberships');
                    $relations->hasMany('alliance')->readOnly();
                    $relations->hasMany('characters')->readOnly();
                    $relations->hasMany('replacement-claims');
                    $relations->hasMany('invoices');
                    $relations->hasMany('received-invoices', 'invoices');
                    $relations->hasMany('notifications');
                });

            $api->resource('alliances')
                ->relationships(function (RelationshipsRegistration $relations) {
                    $relations->hasOne('default-membership-level', 'membership-levels');

                    $relations->hasMany('handbooks');
                    $relations->hasMany('members', 'memberships');
                    $relations->hasMany('membership-levels');
                    $relations->hasMany('memberships');
                    $relations->hasMany('coalition')->readOnly();
                    $relations->hasMany('corporations')->readOnly();
                    $relations->hasMany('replacement-claims');
                    $relations->hasMany('invoices');
                    $relations->hasMany('received-invoices', 'invoices');
                    $relations->hasMany('notifications');
                });

            $api->resource('coalitions')
                ->relationships(function (RelationshipsRegistration $relations) {
                    $relations->hasOne('default-membership-level', 'membership-levels');
                    $relations->hasOne('leader', 'characters');

                    $relations->hasMany('handbooks');
                    $relations->hasMany('members', 'memberships');
                    $relations->hasMany('membership-levels');
                    $relations->hasMany('memberships');
                    $relations->hasMany('alliances')->readOnly();
                    $relations->hasMany('replacement-claims');
                    $relations->hasMany('invoices');
                    $relations->hasMany('received-invoices', 'invoices');
                    $relations->hasMany('notifications');
                });

            $api->resource('billing-conditions')
                ->relationships(function (RelationshipsRegistration $relations) {
                    $relations->hasOne('organization'); // TODO: find out how to route for polymorphic relations

                    $relations->hasMany('discounts');
                    $relations->hasMany('membership-fees');
                });

            $api->resource('comments')
                ->relationships(function (RelationshipsRegistration $relations) {
                    $relations->hasOne('character');
                    $relations->hasOne('commentable'); // TODO: find out how to route for polymorphic relations

                    $relations->hasMany('comments');
                });

            $api->resource('discounts')
                ->relationships(function (RelationshipsRegistration $relations) {
                    $relations->hasOne('organization'); // TODO: find out how to route for polymorphic relations
                    $relations->hasOne('billing-condition');
                });

            $api->resource('doctrines')
                ->relationships(function (RelationshipsRegistration $relations) {
                    $relations->hasOne('organization'); // TODO: find out how to route for polymorphic relations
                    $relations->hasOne('created-by', 'characters');
                    $relations->hasOne('last-updated-by', 'characters');

                    $relations->hasMany('fittings');
                });

            $api->resource('fittings')
                ->relationships(function (RelationshipsRegistration $relations) {
                    $relations->hasOne('organization'); // TODO: find out how to route for polymorphic relations
                    $relations->hasOne('doctrine');

                    $relations->hasMany('replacement-claims');
                });

            $api->resource('fleets')
                ->relationships(function (RelationshipsRegistration $relations) {
                    $relations->hasOne('organization'); // TODO: find out how to route for polymorphic relations
                    $relations->hasOne('fleet-type');
                    $relations->hasOne('created-by', 'characters');
                    $relations->hasOne('last-updated-by', 'characters');

                    $relations->hasMany('comments');
                    $relations->hasMany('notifications');
                });

            $api->resource('fleet-members')
                ->relationships(function (RelationshipsRegistration $relations) {
                    $relations->hasOne('fleet')->readOnly();
                    $relations->hasOne('wing')->readOnly();
                    $relations->hasOne('squad')->readOnly();
                })->readOnly();

            $api->resource('fleet-types')
                ->relationships(function (RelationshipsRegistration $relations) {
                    $relations->hasOne('organization'); // TODO: find out how to route for polymorphic relations

                    $relations->hasMany('fleets');
                });

            $api->resource('handbooks')
                ->relationships(function (RelationshipsRegistration $relations) {
                    $relations->hasOne('organization'); // TODO: find out how to route for polymorphic relations
                    $relations->hasOne('created-by', 'characters');
                    $relations->hasOne('last-updated-by', 'characters');
                });

            $api->resource('invoices')
                ->relationships(function (RelationshipsRegistration $relations) {
                    $relations->hasOne('issuer'); // TODO: find out how to route for polymorphic relations
                    $relations->hasOne('recipient'); // TODO: find out how to route for polymorphic relations
                    $relations->hasOne('last-updated-by', 'characters');

                    $relations->hasMany('items');
                    $relations->hasMany('payments')->readOnly();
                    $relations->hasMany('comments');
                    $relations->hasMany('notifications');
                });

            $api->resource('invoice-items')
                ->relationships(function (RelationshipsRegistration $relations) {
                    $relations->hasOne('invoice');

                    $relations->hasMany('comments');
                });

            $api->resource('memberships')
                ->relationships(function (RelationshipsRegistration $relations) {
                    $relations->hasOne('organization'); // TODO: find out how to route for polymorphic relations
                    $relations->hasOne('membership-level');
                    $relations->hasOne('member'); // TODO: find out how to route for polymorphic relations
                    $relations->hasOne('created-by', 'characters');
                    $relations->hasOne('last-updated-by', 'characters');

                    $relations->hasMany('notifications');
                });

            $api->resource('membership-fees')
                ->relationships(function (RelationshipsRegistration $relations) {
                    $relations->hasOne('organization'); // TODO: find out how to route for polymorphic relations

                    $relations->hasMany('billing-conditions');
                });

            $api->resource('membership-levels')
                ->relationships(function (RelationshipsRegistration $relations) {
                    $relations->hasOne('organization'); // TODO: find out how to route for polymorphic relations
                    $relations->hasOne('created-by', 'characters');
                    $relations->hasOne('last-updated-by', 'characters');

                    $relations->hasMany('memberships');
                });

            $api->resource('permissions')
                ->relationships(function (RelationshipsRegistration $relations) {
                    $relations->hasMany('membership-levels');
                })->readOnly();

            $api->resource('queue-jobs')
                ->relationships(function (RelationshipsRegistration $relations) {
                    $relations->hasOne('resource'); // TODO: find out how to route for polymorphic relations
                })->readOnly();

            $api->resource('replacement-claims')
                ->relationships(function (RelationshipsRegistration $relations) {
                    $relations->hasOne('organization'); // TODO: find out how to route for polymorphic relations
                    $relations->hasOne('character');

                    $relations->hasMany('comments');
                    $relations->hasMany('notifications');
                });

            $api->resource('roles')
                ->relationships(function (RelationshipsRegistration $relations) {
                    $relations->hasOne('organization'); // TODO: find out how to route for polymorphic relations

                    $relations->hasMany('permissions');
                    $relations->hasMany('characters');
                    $relations->hasMany('membership-levels');
                });

            $api->resource('rsvps')
                ->relationships(function (RelationshipsRegistration $relations) {
                    $relations->hasOne('fleet');
                    $relations->hasOne('character');
                });

            $api->resource('squads')
                ->relationships(function (RelationshipsRegistration $relations) {
                    $relations->hasOne('wing')->readOnly();

                    $relations->hasMany('members')->readOnly();
                })->readOnly();

            $api->resource('subscriptions')
                ->relationships(function (RelationshipsRegistration $relations) {
                    $relations->hasOne('organization'); // TODO: find out how to route for polymorphic relations
                    $relations->hasOne('character');
                });

            $api->resource('wings')
                ->relationships(function (RelationshipsRegistration $relations) {
                    $relations->hasOne('fleet')->readOnly();

                    $relations->hasMany('squads')->readOnly();
                })->readOnly();
        });
    });
});
