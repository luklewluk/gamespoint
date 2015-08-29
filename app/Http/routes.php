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

Route::get('/', 'HomeController@index');

Route::controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
]);

Route::group(['middleware' => 'auth'], function () {
    // Library management & list of your games
    Route::get('/user/library', 'UserController@index');
    Route::get('/user/library/add/{id}', 'UserController@gameAdd');
    // Pass/email/nick change...
    Route::get('/user/profile', 'UserController@edit');
    Route::get('/profile/{id}', 'UserController@show');
    // Compare user's library with yours
    Route::get('/profile/{id}/compare', 'UserController@compare');
    // Search by id/name/email
    Route::get('/profile/search', 'UserController@search');
});

Route::get('/user', function(){
    return redirect('user/library');
});

Route::get('/user/login', function(){
    return view('auth.login');
});

Route::get('/user/logout', 'UserController@logout');

Route::get('/user/register', function(){
   return view('auth.register');
});

// Games list
Route::get('/games', 'GameController@index');
// Game details
Route::get('/game/{id}', 'GameController@show');
