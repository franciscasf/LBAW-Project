<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use Illuminate\View\View;

use App\Models\User;

class RegisterController extends Controller
{
    /**
     * Display a login form.
     */
    public function showRegistrationForm(): View
    {
        return view('auth.register');
    }

    /**
     * Register a new user.
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'min:3', 
                'max:20', 
                'regex:/^(?!.*DELETED).*[\w\sáàãâäéèêëíìîïóòôöúùûüç\.\-_]+$/i',
                'unique:user,name',
            ],
            'email' => [
                'required',
                'email:rfc',  // Validates the email format using RFC 5322
                'max:250',
                'unique:user,email', // Checks email is unique 
            ],
            'password' => 'required|min:8|confirmed'
        ], [
            'name.required' => 'The username is required.',
            'name.max' => 'The username must not exceed 250 characters.',
            'email.required' => 'The email address is required.',
            'email.email' => 'Please provide a valid email address (RFC 5322 format).',
            'email.unique' => 'The email address is already in use.',
            'password.required' => 'The password is required.',
            'password.min' => 'The password must be at least 8 characters.',
            'password.confirmed' => 'The password confirmation does not match.',
        ]);


        User::create([
            'first_name' => 'NEW',
            'last_name' => 'USER',
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'profile_picture'=> 'profile_pictures/7q8OoIMKQPTfsmgx0ypnYXtPkgWtbiEy6AhbPoOZ.jpg',
        ]);

        $credentials = $request->only('email', 'password');
        Auth::attempt($credentials);
        $request->session()->regenerate();
        return redirect()->route('home')
            ->withSuccess('You have successfully registered & logged in!');
    }
}
