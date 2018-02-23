<?php
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'WelcomeController@index')->name('welcome');

Route::resource('characters', 'CharacterController', ['except' => [
    'edit'
]]);

Route::prefix('characters/{id}')->group(function () {
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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
