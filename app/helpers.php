<?php

use App\Support\DynamicContent;

if (! function_exists('dynamic_content')) {
    function dynamic_content(string $path, mixed $fallback = null): mixed
    {
        return app(DynamicContent::class)->get($path, $fallback);
    }
}
