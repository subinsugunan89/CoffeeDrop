<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('location','LocationController@index');
Route::get('getNearestLocation/{postcode}','LocationController@getNearestLocation');
Route::post('createNewLocation/','LocationController@createNewLocation');
Route::post('calculateCashback/','PoditemsController@quote');