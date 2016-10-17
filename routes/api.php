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

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::get('/user/{username}', 'ApiController@getUser')->middleware('auth:api');

Route::get('/teams', 'ApiController@getTeams');
Route::get('/team/{number}', 'ApiController@getTeam')->middleware('auth:api');
Route::get('/team/{number}/members', 'ApiController@teamMembers')->middleware('auth:api');