<?php

namespace App\Notifications\Auth;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Auth\Notifications\ResetPassword as ResetPasswordNotification;

class ResetPassword extends ResetPasswordNotification implements ShouldQueue
{
    use Queueable;

    public $token;

    public function __construct($token)
    {
        //required to persist the token for the queue
        $this->token = $token;
        //specifying queue is optional but recommended
//        $this->queue = 'auth';
    }
}
