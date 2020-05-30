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


Route::post('user/login', 'Api\UserController@login');
Route::post('user/reg', 'Api\UserController@register');

Route::group(['middleware' => 'auth:api'], function () {
    Route::get('user/details', 'Api\UserController@details');
    Route::get('user/lookup/{userName}', 'Api\UserController@userLookup');
});

// Route::get('events', 'Api\EventController@index')->middleware('auth:api');

// Listing Auth
Route::group(['middleware' => 'auth:api'], function () {

    Route::get('events', 'Api\EventController@index');
    Route::get('events/{event}', 'Api\EventController@show');
    Route::post('events', 'Api\EventController@store');
    Route::put('events/{event}', 'Api\EventController@update');
    Route::delete('events/{event}', 'Api\EventController@destroy');

    Route::get('purchases', 'Api\PurchaseController@index');
    Route::get('purchases/{purchase}', 'Api\PurchaseController@show');
    Route::post('purchases', 'Api\PurchaseController@store');
    Route::put('purchases/{purchase}', 'Api\PurchaseController@update');
    Route::delete('purchases/{purchase}', 'Api\PurchaseController@destroy');

    Route::get('payments', 'Api\PaymentController@index');
    Route::get('payments/{payment}', 'Api\PaymentController@show');
    Route::post('payments', 'Api\PaymentController@store');
    Route::put('payments/{payment}', 'Api\PaymentController@update');
    Route::delete('payments/{payment}', 'Api\PaymentController@destroy');

});