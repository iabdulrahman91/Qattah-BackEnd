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
Route::post('user/register', 'Api\UserController@register');

Route::group(['middleware' => 'auth:api'], function () {
    Route::get('user/details', 'Api\UserController@details');
    Route::get('user/lookup/{userName}', 'Api\UserController@userLookup');
});

// Route::get('events', 'Api\EventController@index')->middleware('auth:api');

// Listing Auth
Route::group(['middleware' => 'auth:api'], function () {

    Route::get('events', 'Api\EventController@index');
    // adding new Listing
    Route::post('events', 'Api\EventController@store');

    // Security: changed {event}to id because we want to prevent 404 to show.
    // it should send 401 whenever a user try to access other users event or the listing is not existed
    Route::put('events/{event}', 'Api\EventController@update');
    Route::delete('events/{event}', 'Api\EventController@destroy');

});