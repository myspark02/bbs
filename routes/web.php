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
/*
Route::get('bbs', ['as'=>'bbs', 'uses'=>'BBSController@index']);

Route::get('write', 'BBSController@create');

Route::post('write','BBSController@store');

Route::get('view', 'BBSController@show');

Route::get('modify', 'BBSController@edit');

Route::post('modify', 'BBSController@update');

Route::post('delete', 'BBSController@destroy');
*/

Route::resource('bbs', 'BBSController');

Route::get('myarticles', 'BBSController@myArticles')->name('bbs.myarticles');

Route::get('master', function(){
	return view('layouts.master');
});

/* 사용자 가입 */
Route::get('auth/register', [
	'as'=>'users.create', 
	'uses'=>'UsersController@create',
]);

Route::post('auth/register', [
	'as'=>'users.store', 
	'uses'=>'UsersController@store',
]);

Route::get('auth/confirm/{code}', [
	'as'=>'users.confirm', 
	'uses'=>'UsersController@confirm',
]);

/* 사용자 인증 */
Route::get('auth/login', [
	'as'=>'sessions.create', 
	'uses'=>'SessionsController@create',
]);

Route::post('auth/login', [
	'as'=>'sessions.store', 
	'uses'=>'SessionsController@store',
]);

Route::get('auth/logout', [
	'as'=>'sessions.destroy', 
	'uses'=>'SessionsController@destroy',
]);


/* 비밀번호 초기화 */
Route::get('auth/remind', [
	'as'=>'remind.create', 
	'uses'=>'PasswordsController@getRemind',
]);

Route::post('auth/remind', [
	'as'=>'remind.store', 
	'uses'=>'PasswordsController@postRemind',
]);

Route::get('auth/reset/{token}', [
	'as'=>'reset.create', 
	'uses'=>'PasswordsController@getReset',
]);

Route::post('auth/reset', [
	'as'=>'reset.store', 
	'uses'=>'PasswordsController@postReset',
]);

Route::get('social/{provider}', [
	'as' => 'social.login',
	'uses' => 'SocialController@redirectToProvider',
]);

Route::get('social/{provider}/callback', [
	'as' => 'social.callback',
	'uses' => 'SocialController@handleProviderCallback',
]);

Route::get('auth/confirm/{code}',    
	[
	'as' => 'users.confirm',
    'uses' => 'UsersController@confirm',
	])->where('code', '[\pL-\pN]{60}');

Route::get('login', [
	'as'=>'sessions.create', 
	'uses'=>'SessionsController@create',
]);

Route::get('auth/email', [
	'as'=>'user.email',
	'uses'=>'UsersController@checkEmail'

]);

Route::resource('attachments', 'AttachmentsController', ['only'=>['store', 'destroy']]);

