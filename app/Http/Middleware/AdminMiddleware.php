<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!session('user_id') || session('role') !== 'admin') {
            return redirect('/login');
        }

        return $next($request);
    }
}
