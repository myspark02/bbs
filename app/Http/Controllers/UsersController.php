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
        $socialUser = \App\User::whereEmail($request->email)->whereNull('password')->first();

        if($socialUser) {
            return $this->updateSocialAccount($request, $socialUser);
        }

        return $this->createNativeAccount($request);

    } 

    protected function updateSocialAccount(Request $request, User $user)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'password' => 'required|confirmed|min:6',
        ]);
        $user->update([
            'name' => $request->input('name'),
            'password' => bcrypt($request->input('password')),
        ]);

        auth()->login($user);
        flash(auth()->user()->name . '님, 환영합니다.');

        return redirect('bbs'); 
    }   


    protected function createNativeAccount(Request $request) {
        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
        ]);
       // event(new \App\Events\UserCreated($user));
      
        auth()->login($user);
        flash(auth()->user()->name . '님, 환영합니다.');

        return redirect('bbs'); 
    }    
}
