<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\User;

class SessionsController extends Controller
{
	
	
    public function __construct() {
    	$this->middleware('guest', ['except'=>'destroy']);
    }

    public function create() {
    	return view('sessions.create');
    }

    public function store(Request $request) {
    	$this->validate($request, [
    		'email' => 'required|email',
    		'password' => 'required|min:6',
    	]);

        \Log::debug('login', ['step1'=>'before check wether email confirmed user or not']);

        $user = User::whereEmail($request->email)->whereNotNull('confirm_code')->first();
        if ($user) { // 사용자 이메일 인증이 아직 되지 않은 사용자
            flash('이메일 인증이 완료되지 않았습니다.');
            return back()->withInput();
        }
        \Log::debug('login', ['step2'=>'before email and password check']);

    	if(!Auth::attempt($request->only('email', 'password'), $request->has('remember'))) {
    		flash('이메일 또는 비밀번호가 맞지 않습니다.');
    		return back()->withInput();
    	}
    	//Auth::logoutOtherDevices($request->password);
        \Log::debug('login', ['step3'=>'before redirection to bbs']);

    	flash(Auth::user()->name . '님 환영합니다.');
    	return redirect()->intended(route('bbs.index'));
        //return redirect(route('bbs'));
    }

    public function destroy() {
    	Auth::logout();
    	flash('또 방문해 주세요');

    	return redirect(route('sessions.create'));
    }
}
