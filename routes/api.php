<?php

use Illuminate\Http\Request;
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

Route::resource('characters', 'CharacterController', ['except' => [
    'edit'
]]);

Route::prefix('characters/{id}')->middleware('auth:api')->group(function () {
    Route::resources([
        'coalitions' => 'CoalitionController',
        'comments' => 'CommentController',
        'discounts' => 'DiscountController',
        'doctrines' => 'DoctrineController',
        'handbooks' => 'HandbookController',
        'invoices' => 'InvoiceController',
        'memberships' => 'MembershipController',
        'replacements' => 'ReplacementClaimController',
        'settings' => 'SettingController',
    ]);
});
