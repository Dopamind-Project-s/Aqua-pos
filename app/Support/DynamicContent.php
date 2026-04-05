<?php

namespace App\Support;

use App\Models\PageSection;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;

class DynamicContent
{
    public function get(string $path, mixed $fallback = null): mixed
    {
        [$pageKey, $sectionKey, $fieldPath] = $this->parsePath($path);

        if (! Schema::hasTable('page_sections')) {
            return $this->resolveFallback($path, $fallback);
        }

        $payload = Cache::remember(
            $this->cacheKey($pageKey, $sectionKey),
            now()->addMinutes(30),
            fn () => PageSection::query()
                ->where('page_key', $pageKey)
                ->where('section_key', $sectionKey)
                ->first()
        );

        if (! $payload || ! $payload->is_visible) {
            return $this->resolveFallback($path, $fallback);
        }

        $content = Arr::get($payload->content_json ?? [], $fieldPath);

        return $content ?? $this->resolveFallback($path, $fallback);
    }

    public function page(string $pageKey): array
    {
        if (! Schema::hasTable('page_sections')) {
            return [];
        }

        return Cache::remember(
            "cms:page:{$pageKey}",
            now()->addMinutes(30),
            fn () => PageSection::query()
                ->where('page_key', $pageKey)
                ->orderBy('sort_order')
                ->get()
                ->mapWithKeys(fn (PageSection $row) => [$row->section_key => [
                    'id' => $row->id,
                    'content' => $row->content_json ?? [],
                    'style' => $row->style_json ?? [],
                    'is_visible' => $row->is_visible,
                    'sort_order' => $row->sort_order,
                ]])
                ->all()
        );
    }

    public function flush(string $pageKey, string $sectionKey): void
    {
        Cache::forget($this->cacheKey($pageKey, $sectionKey));
        Cache::forget("cms:page:{$pageKey}");
    }

    private function resolveFallback(string $path, mixed $fallback): mixed
    {
        return config("dynamic-content.defaults.{$path}", $fallback);
    }

    private function parsePath(string $path): array
    {
        $parts = explode('.', $path);
        $page = array_shift($parts) ?? 'global';
        $section = array_shift($parts) ?? 'default';
        $fieldPath = implode('.', $parts);

        return [$page, $section, $fieldPath];
    }

    private function cacheKey(string $pageKey, string $sectionKey): string
    {
        return "cms:section:{$pageKey}:{$sectionKey}";
    }
}
