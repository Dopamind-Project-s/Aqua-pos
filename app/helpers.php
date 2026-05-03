<?php

use App\Support\DynamicContent;

if (! function_exists('dynamic_content')) {
    function dynamic_content(string $path, mixed $fallback = null): mixed
    {
        return app(DynamicContent::class)->get($path, $fallback);
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
