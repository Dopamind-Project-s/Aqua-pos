<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class PublicMediaController extends Controller
{
    public function show(string $path): Response
    {
        abort_if(str_contains($path, '..'), 404);

        $disk = Storage::disk('public');
        $normalizedPath = ltrim($path, '/');

        abort_unless($disk->exists($normalizedPath), 404);

        $absolutePath = $disk->path($normalizedPath);
        $mimeType = $disk->mimeType($normalizedPath) ?: 'application/octet-stream';

        return response()->file($absolutePath, [
            'Content-Type' => $mimeType,
            'Cache-Control' => 'public, max-age=86400',
        ]);
    }
}
