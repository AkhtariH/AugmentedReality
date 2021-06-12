<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

use App\Models\User;
use App\Mail\ResetMail;

use Mail;

class PasswordResetController extends Controller
{
    const MAIL_SUCCESS = 'The reset email has been sent succefully!';
    const MAIL_FAILURE = 'The entered email address does not exist!';

    public function index() {
        return view('auth.forgot-password');
    }

    public function email(Request $request) {
        $request->validate(['email' => 'required|email']);
        $user = User::where('email', $request->email)->first();
        
        if ($user !== null) {
            $status = self::MAIL_SUCCESS;
            $token = Password::getRepository()->create($user);

            Mail::to($user)->send(new ResetMail($user, $token));
        } else {
            $status = self::MAIL_FAILURE;
        }

    
        return $status === self::MAIL_SUCCESS
                    ? back()->with(['status' => __($status)])
                    : back()->withErrors(['email' => __($status)]);
    }

    public function reset($token, $email = null) {
        return view('auth.reset-password', ['token' => $token, 'email' => $email]);
    }

    public function update(Request $request) {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);
    
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->save();
    
                $user->setRememberToken(Str::random(60));
    
                event(new PasswordReset($user));
            }
        );
    
        return $status == Password::PASSWORD_RESET
                    ? redirect()->route('login')->with('status', __($status))
                    : back()->withErrors(['email' => __($status)]);
    }

}
