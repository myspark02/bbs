<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;

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
        $socialUser = User::whereEmail($request->email)->whereNull('password')->first();

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

        $confirmCode = str_random(60);


        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'confirm_code' => $confirmCode,
        ]);

        \Log::info('register', ['confirm_code'=>$user->confirm_code]);
        
        event(new \App\Events\UserCreated($user));
      
       // auth()->login($user);
        //flash(auth()->user()->name . '님, 환영합니다.');

       
        return redirect(route('sessions.create')); 
    }    

    public function confirm($code) {
        $user = User::whereConfirmCode($code)->first();

        if (!$user) {
            flash('URL이 정확하지 않습니다.');
            return redirect(route('users.create'));
        }

        $user->activated = 1;
        $user->confirm_code = null;
        $user->save();

        auth()->login($user);

        flash(auth()->user()->name . '님, 환영합니다. 가입 확인되었습니다.');

        return redirect('bbs'); 

    }

    public function checkEmail(Request $request) {
        $cnt = User::whereEmail($request->email)->get()->count();
        
        if ($cnt)
            return response()->json('true', 200);
        else
            return response()->json('false', 200);

    }
}
