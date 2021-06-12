<?php

namespace App\Listeners;

use App\Events\NewUserRegistered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Password;
use Illuminate\Mail\Message;

use App\Models\User;
use App\Mail\WelcomeMail;

use Mail;

class SendWelcomeEmail
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
     * @param  NewUserRegistered  $event
     * @return void
     */
    public function handle(NewUserRegistered $event)
    {
        $user = $event->user;
        $token = Password::getRepository()->create($user);
        
        Mail::to($user)->send(new WelcomeMail($user, $token));
    }
}
