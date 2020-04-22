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

Route::post('register', 'Api\UserController@register');
Route::post('login', 'Api\UserController@login');
Route::get('user', 'Api\UserController@user');
Route::get('logout', 'Api\UserController@logout');

Route::get('list', 'Api\UserController@list');
Route::post('create', 'Api\UserController@store');
Route::put('update/{userId}', 'Api\UserController@update');
Route::delete('delete/{userId}', 'Api\UserController@destroy');

