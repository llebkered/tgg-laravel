<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAccessMiddleware
{
    /**
     * Checks if user is in admin group
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::check()) {

            if ($request->user()->role->name == 'admin') {
                return $next($request);
            }

            return redirect('/');
        }

        return redirect('/login');
    }
}
