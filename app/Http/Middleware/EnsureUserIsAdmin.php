<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAdmin
{
    /**
     * Handle an incoming request.
     *
     * Pair this with the 'auth' middleware on the route/group: this only
     * checks the role, it does not check whether the user is logged in.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user() || ! $request->user()->isAdmin()) {
            abort(403, 'Kamu tidak punya akses ke halaman admin.');
        }

        return $next($request);
    }
}
