<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('hello/world', function(){
	return 'Hello World';
});
Route::get('bbs', 'BBSController@index');

Route::get('write', 'BBSController@create');

Route::post('write','BBSController@store');

Route::get('view', 'BBSController@show');

Route::get('modify', 'BBSController@edit');

Route::post('modify', 'BBSController@update');

Route::post('delete', 'BBSController@destroy');

Route::get('master', function(){
	return view('layouts.master');
});
