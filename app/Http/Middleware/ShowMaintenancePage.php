<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

/**
 * While maintenance is turned on in the backend, visitors see the maintenance
 * page. Admins see the site as normal, and the backend, login and password
 * reset stay open so an admin can always sign in and turn it off.
 */
class ShowMaintenancePage
{
    public function handle(Request $request, Closure $next)
    {
        if (! option('maintenance')
            || $request->user()?->isAdmin()
            || $request->is('backend', 'backend/*')
            || $request->routeIs('login', 'logout', 'password.*')) {
            return $next($request);
        }

        // 503 with Retry-After tells search engines the page is only away
        // for now, so they keep it in their index.
        return response()->view('maintenance', [], 503)->header('Retry-After', 3600);
    }
}
