<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckDirectorOricRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role->name === 'Director ORIC') {
            return $next($request);
        }

        // Redirect or abort if the user is not 'Director ORIC'
        return redirect('/login')->with('error', 'You do not have permission to access this page.');
    }
}
