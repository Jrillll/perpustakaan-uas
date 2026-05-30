<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Allow if user is authenticated and has role 'admin'
        if (Auth::check() && Auth::user()?->role === 'admin') {
            return $next($request);
        }

        // Fallback for the dev-admin session helper (legacy support)
        if (session('user_id')) {
            $user = User::find(session('user_id'));

            if ($user && $user->role === 'admin') {
                // Optionally log the user in for the request lifecycle
                Auth::login($user);

                return $next($request);
            }
        }

        return redirect()->route('login');

    }
}
