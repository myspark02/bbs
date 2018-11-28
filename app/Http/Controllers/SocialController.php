<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SocialController extends Controller
{
    //
    public function __construct() {
    	$this->middleware('guest');
    }

    public function redirectToProvider($provider) {
    	\Log::debug('redirectToProvider', ['provider'=>$provider]);
    	return \Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback($provider) {
    	\Log::debug('handleProviderCallback', ['provider'=>$provider]);
    	$user = \Socialite::driver($provider)->user();

    	$user = (\App\User::whereEmail($user->getEmail())->first())
            ?: \App\User::create([
                'name'  => $user->getName() ?: 'unknown',
                'email' => $user->getEmail(),
                'activated' => 1,
            ]);
        auth()->login($user);
        flash(
            trans('messages.sessions.info_welcome', ['name' => auth()->user()->name])
        );
        return redirect(route('bbs.index'));
    }
}
