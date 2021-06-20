<?php

namespace App\Listeners;

use App\Events\ThresholdExceeded;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Mail\Message;
use App\Models\User;
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
        $data = $event->data;
        $admins = User::where('type', 'admin')->get();
        $to = [];
        foreach ($admins as $admin) {
            array_push($to, $admin->email);
        }

        Mail::send('emails.threshold', ['data' => $data], function (Message $message) use ($to){
            $message->subject(config('app.name') . ' - New Art Object');
            $message->to($to);
        });
    }
}
