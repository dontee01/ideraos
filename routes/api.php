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


Route::post('save/country', 'ExploreController@add_country');

Route::post('save/state', 'ExploreController@add_state');

Route::post('save/city', 'ExploreController@add_city');


Route::get('list/countries', 'ExploreController@show_countries');

Route::post('list/states', 'ExploreController@show_states');

// state_id
// Route::post('list/cities-states', 'ExploreController@show_cities_by_states');

// Route::post('find/city', 'ExploreController@show_city');

Route::post('find/cities-country', 'ExploreController@show_cities_by_country');