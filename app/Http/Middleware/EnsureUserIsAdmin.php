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

        $isAdmin = property_exists($user, 'is_admin') ? (bool) $user->is_admin : true;

        if (! $isAdmin) {
            abort(403, 'Admin access only.');
        }

        return $next($request);
    }
}
