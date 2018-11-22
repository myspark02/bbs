<?php

namespace App\Listeners;

use App\Events\PasswordRemindCreated;
use App\Events\UserCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UsersEventListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  PasswordRemindCreated  $event
     * @return void
     */
    public function handle($event)
    {
        if($event instanceof PasswordRemindCreated) {
            $email = $event->email;
            $token = $event->token;

            \Mail::send('emails.passwords.reset', compact('token'), function($message) use ($email){
                $message->to($email);
                $message->subject('비밀번호를 초기화하세요.');
            });

            flash('비밀번호를 바꾸는 방법을 담은 이메일을 발송했습니다. 메일박스를 확인해 주세요');
        } else if($event instanceof UserCreated) {
                   $user = $event->user;
        
            \Mail::send(
                'emails.auth.confirm', compact('user'),
                function ($message) use ($user) {
                    $message->to($user->email);
                    $message->subject('회원 가입을 확인해 주세요');
                }
            );
            flash('등록하신 메일 계정으로 가입 확인 메일을 보내드렸습니다. 가입 확인하시고 로그인 해 주세요');
        }
    }
}
