<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckIfUserDeleted
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->isDeleted()) {
            Auth::logout(); 
            return redirect('/')->with('error', 'Your account has been deleted.');
        }

        return $next($request);
    }
}
