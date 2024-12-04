<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewerRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
{
    if (auth()->check() && auth()->user()->role->name == 'reviewer') {
        \Log::info('Reviewer role confirmed');
        return $next($request);
    }

    \Log::warning('Access denied: User is not a reviewer');
    return redirect('/dashboard');
}

}
