<?php

namespace App\Listeners;

use App\Events\ThresholdExceeded;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Mail\Message;
use Mail;


class SendAlertEmail
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
     * @param  ThresholdExceeded  $event
     * @return void
     */
    public function handle(ThresholdExceeded $event)
    {
        $overtime = $event->overtime;

  
        Mail::send('emails.threshold', ['overtime' => $overtime], function (Message $message) use ($overtime){
            $message->subject(config('app.name') . ' - Überstunden Warnung');
            $message->to($overtime->supervisor_email);
        });
    }
}
