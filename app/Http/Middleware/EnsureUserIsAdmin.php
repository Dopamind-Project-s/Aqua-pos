<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user) {
            abort(403, 'Authentication required.');
        }

        if (! (bool) data_get($user, 'is_admin', false)) {
            abort(403, 'Admin access only.');
        }

        return $next($request);
    }
}
