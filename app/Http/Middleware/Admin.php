<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Admin
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
        if (auth()->user() == null) {
            return redirect('/');
        } else if (auth()->user()->role == 0) {
            return $next($request);
        } else {
            return abort(403);
        }
    }
}
