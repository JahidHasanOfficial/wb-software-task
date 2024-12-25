<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the user is authenticated
        if (Auth::check()) {
            // If the user is not an admin, deny access
            if (Auth::user()->user_type != 'admin') {
                session()->flash('error', 'Access denied. You are not an admin.');
                return redirect()->route('login');
            }
            // Proceed to the next middleware/controller if the user is an admin
            return $next($request);
        }
    
        // Redirect unauthenticated users to the login page
        return redirect()->route('login');
    }
}
    