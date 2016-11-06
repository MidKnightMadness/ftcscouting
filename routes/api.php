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

Route::post('/invite', 'ApiController@sendInvite')->middleware('auth:api');
Route::post('/invite/cancel', 'ApiController@cancelInvite')->middleware('auth:api');

Route::get('/survey/{survey}/questions', 'ApiController@getSurveyQuestions')->middleware('auth:api');
Route::get('/survey/{survey}/new-question', 'ApiController@newSurveyQuestion');

Route::post('/question/{id}/delete', 'ApiController@deleteQuestion')->middleware('auth:api');
Route::post('/question/{id}/update', 'ApiController@updateQuestion')->middleware('auth:api');