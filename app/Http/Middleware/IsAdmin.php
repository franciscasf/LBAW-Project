<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User; 

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        
        if (auth()->user() && auth()->user()->isAdmin) {
            return $next($request); 
        }

        // If the user is not an admin, deny access with 403
        return response()->json([
            'message' => 'Access denied. Admin privileges required.',
            'is_admin' => false
        ], 403);
    }
}
