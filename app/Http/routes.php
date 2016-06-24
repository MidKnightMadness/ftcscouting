<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
})->middleware(['web']);

Route::auth();

Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
Route::get('/home', function(){
    return redirect(route('dashboard'));
});

Route::get('/teams', 'TeamController@showAllTeams')->name('teams.all');

// Profile routes
Route::get('/profile/edit', 'ProfileController@edit')->name('profile.edit')->middleware(['auth']);
Route::patch('/profile/edit', 'ProfileController@update')->name('profile.update')->middleware(['auth']);
Route::delete('/profile/edit', 'ProfileController@delete')->middleware(['auth']);
Route::get('/profile/{number}', 'ProfileController@profile')->name('profile.show');
