<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UsersController extends Controller
{
    //

    public function __construct() {
    	return $this->middleware('guest');
    }

    public function create() {
    	return view('users.create');
    }

    public function store(Request $request) {
    	$this->validate($request, [
    			'name'=>'required|max:255',
    			'email'=>'required|email|max:255|unique:users',
    			'password'=>'required|confirmed|min:6',
    		]);

    	$user = \App\User::create([
    			'name'=>$request->name,
    			'email'=>$request->email,
    			'password'=>bcrypt($request->password),
    			'account'=>'0',
    	]);

    	auth()->login($user);
    	flash(auth()->user()->name . '님, 환영합니다.');

    	return redirect('bbs');	
    } 
}
