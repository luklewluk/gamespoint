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

// TODO: Create methods below
Route::get('/user/login', 'UserController@login');
Route::get('/user/register', 'UserController@create');
// Library management & list of your games
Route::get('/user/library', 'UserController@index');
// Pass/email/nick change...
Route::get('/user/profile', 'UserController@edit');
Route::get('/profile/{id}', 'UserController@show');
// Compare user's library with yours
Route::get('/profile/{id}/compare', 'UserController@compare');
// Search by id/name/email
Route::get('/profile/search', 'UserController@search');
// Game details
Route::get('/game/{id}', 'GameController@show');
