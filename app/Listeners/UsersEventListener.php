<?php

namespace App\Listeners;

use App\Events\PasswordRemindCreated;
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
    public function handle(PasswordRemindCreated $event)
    {
        $email = $event->email;
        $token = $event->token;

        \Mail::send('emails.passwords.reset', compact('token'), function($message) use ($email){
            $message->to($email);
            $message->subject('비밀번호를 초기화하세요.');
        });

        flash('비밀번호를 바꾸는 방법을 담은 이메일을 발송했습니다. 메일박스를 확인해 주세요');
    }
}
