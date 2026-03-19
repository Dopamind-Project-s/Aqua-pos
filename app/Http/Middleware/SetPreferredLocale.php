<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetPreferredLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        $allowed = ['en', 'ar'];
        $preferred = (string) ($request->query('lang', $request->cookie('aqua_lang', config('app.locale'))));

        if (! in_array($preferred, $allowed, true)) {
            $preferred = config('app.fallback_locale', 'en');
        }

        app()->setLocale($preferred);

        return $next($request);
    }
}
