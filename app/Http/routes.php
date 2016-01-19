<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('portal');
});
Route::any('/index', function(){
    return redirect("/");
})->name('index');
Route::controller('ajax', 'AjaxController');
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
    Route::controller('team', 'TeamController', [
        'getIndex'=>'team.index',
        'getNew'=>'team.new',
        'putSave'=>'team.save',
        'getList'=>'team.list',
        'getEdit'=>'team.edit'
    ]);
    Route::controller('match', 'MatchController',[
        'getNew' => 'match.add',
        'putSave' =>'match.new',
        'getDetails'=>'match.details'
    ]);
});
