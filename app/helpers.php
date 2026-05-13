<?php

use App\Support\DynamicContent;

if (! function_exists('dynamic_content')) {
    function dynamic_content(string $path, mixed $fallback = null): mixed
    {
        return app(DynamicContent::class)->get($path, $fallback);
    }
}

if (! function_exists('app_current_locale')) {
    function app_current_locale(): string
    {
        return str_replace('_', '-', app()->getLocale());
    }
}

if (! function_exists('app_is_rtl')) {
    function app_is_rtl(?string $locale = null): bool
    {
        return in_array($locale ?? app()->getLocale(), ['ar'], true);
    }
}

if (! function_exists('app_text_direction')) {
    function app_text_direction(?string $locale = null): string
    {
        return app_is_rtl($locale) ? 'rtl' : 'ltr';
    }
}

if (! function_exists('public_storage_url')) {
    function public_storage_url(?string $path, ?string $fallback = null): string
    {
        if (! $path) {
            return $fallback ?? asset('img/defaults/placeholder.svg');
        }

        if (filter_var($path, FILTER_VALIDATE_URL)) {
            return $path;
        }

        $normalizedPath = ltrim(preg_replace('#^/?storage/#', '', $path), '/');

        if (is_file(public_path($normalizedPath))) {
            return '/'.$normalizedPath;
        }

        return '/storage/'.$normalizedPath;
    }
}
