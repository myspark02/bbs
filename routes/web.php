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
Route::get('bbs', function() {
	return view('bbs.board');
});

Route::get('write', function() {
	return view('bbs.write_form');
	//return 'Write Form';
});

Route::post('write', function() {
	return view('bbs.write');
	//return 'Write Action';
});

Route::get('view', function() {
	return view('bbs.view');
});

Route::get('modify', function(){
	return view('bbs.modify_form');
});

Route::post('modify', function(){
	return view('bbs.modify');
});

Route::post('delete', function(){
	return view('bbs.delete');
});

Route::get('master', function(){
	return view('layouts.master');
});
