<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  mixed  ...$roles
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please log in to continue.');
        }

        $user = Auth::user();

        if ($user->status === 'banned') {
            Auth::logout();
            return redirect()->route('login')->with('error', 'Your account has been suspended. Please contact support.');
        }

        // Admin has universal access
        if ($user->role === 'admin') {
            return $next($request);
        }

        // Check if user's role matches any of the required roles
        if (in_array($user->role, $roles)) {
            return $next($request);
        }

        // Unauthorized role redirect
        return redirect()->route('home')->with('error', 'Access denied. You do not have permission to access this area.');
    }
}
