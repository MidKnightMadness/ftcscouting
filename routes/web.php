<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->middleware(['web']);

Route::auth();
Route::get('/logout', 'Auth\LoginController@logout');

Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
Route::get('/home', function(){
    return redirect(route('dashboard'));
});

Route::get('/teams', 'TeamController@showAllTeams')->name('teams.all');
Route::put('/team/create', 'TeamController@doCreate')->name('teams.doCreate');
Route::get('/team/create', 'TeamController@showCreate')->name('teams.create');
Route::get('/team/{number}', 'TeamController@viewTeam')->name('teams.show');
Route::get('/team/acceptInviteTeam/{teamId}', 'TeamController@postAcceptTeamInvite')->name('teams.teamAcceptInvite');
Route::get('/team/acceptInvite/{inviteNumber}', 'TeamController@acceptTeamInvite')->name('teams.acceptInvite');

// Profile routes
Route::get('/profile/edit', 'ProfileController@edit')->name('profile.edit')->middleware(['auth']);
Route::patch('/profile/edit', 'ProfileController@update')->name('profile.update')->middleware(['auth']);
Route::delete('/profile/edit', 'ProfileController@delete')->middleware(['auth']);
Route::get('/profile/image/{image}/{size}', 'ProfileController@image')->name('profile.image');
Route::get('/profile/{number}', 'ProfileController@profile')->name('profile.show');
