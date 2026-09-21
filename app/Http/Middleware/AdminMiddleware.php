<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check() || !Auth::user()->is_admin) {
            // ✅ Redirect guests and non-admins back to welcome
            return redirect()->route('welcome')->with('error', 'Access denied.');
        }

        return $next($request);
    }
}
