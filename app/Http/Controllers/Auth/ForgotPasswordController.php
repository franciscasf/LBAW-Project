<?php

namespace App\Http\Controllers\Auth;



use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Http\Request; 

class ForgotPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('auth.recoverPassword');
    }

    public function sendResetLinkEmail(Request $request)
    {

        $request->validate(['email' => 'required|email']);


        $user = \App\Models\User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'No user found with that email address.']);
        }

        $newPassword = Str::random(8);

        $user->password = Hash::make($newPassword);
        $user->save();

        Mail::raw("Your password is: $newPassword", function ($message) use ($user) {
            $message->to($user->email)
                ->subject('Password Reset');
        });

        return back()->with('status', 'We have emailed you a new password!');
    }
}