<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class ResetMail extends Mailable
{
    use Queueable, SerializesModels;

    public $token;
    public User $user;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, $token)
    {
        $this->user = $user;
        $this->token = $token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('info@hobohydrauliek.com')
                    ->subject(config('app.name') . ' - Password reset')
                    ->view('emails.forgot-password')
                    ->with([
                        'token' => $this->token,
                        'user' => $this->user,
                    ]);
    }
}
