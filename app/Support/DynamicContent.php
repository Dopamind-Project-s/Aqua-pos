<?php

namespace App\Support;

use App\Models\PageSection;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;

class DynamicContent
{
    private const GLOBAL_PAGE_KEY = 'global';

    private const SHARED_SECTION_KEYS = [
        'header',
        'footer',
    ];

    public function get(string $path, mixed $fallback = null): mixed
    {
        [$pageKey, $sectionKey, $fieldPath] = $this->parsePath($path);

        if (! Schema::hasTable('page_sections')) {
            return $this->resolveFallback($path, $fallback);
        }

        $resolvedPageKey = $this->pageKeyForSection($pageKey, $sectionKey);
        $payload = $this->section($resolvedPageKey, $sectionKey);

        if (! $payload && $resolvedPageKey !== $pageKey) {
            $payload = $this->section($pageKey, $sectionKey);
        }

        if (! $payload || ! $payload->is_visible) {
            return $this->resolveFallback($path, $fallback);
        }

        $contentTree = $payload->content_json ?? [];
        $styleTree = $payload->style_json ?? [];

        $content = $this->resolveTreeValue($contentTree, $fieldPath)
            ?? $this->resolveTreeValue($contentTree, $path);

        if ($content === null && str_contains($fieldPath, '.')) {
            $content = $this->resolveTreeValue($contentTree, str($fieldPath)->afterLast('.')->value());
        }

        if ($content === null && str_starts_with($fieldPath, 'style.')) {
            $content = $this->resolveTreeValue($styleTree, str($fieldPath)->after('style.')->value());
        }

        return $content ?? $this->resolveFallback($path, $fallback);
    }

    public function page(string $pageKey): array
    {
        if (! Schema::hasTable('page_sections')) {
            return [];
        }

        if ($pageKey === self::GLOBAL_PAGE_KEY) {
            return $this->sectionsForPage(self::GLOBAL_PAGE_KEY);
        }

        $globalSections = Arr::only($this->sectionsForPage(self::GLOBAL_PAGE_KEY), self::SHARED_SECTION_KEYS);
        $pageSections = Arr::except($this->sectionsForPage($pageKey), self::SHARED_SECTION_KEYS);

        return array_replace($pageSections, $globalSections);
    }

    public function pageKeyForSection(string $pageKey, string $sectionKey): string
    {
        return in_array($sectionKey, self::SHARED_SECTION_KEYS, true)
            ? self::GLOBAL_PAGE_KEY
            : $pageKey;
    }

    public function flush(string $pageKey, string $sectionKey): void
    {
        Cache::forget($this->cacheKey($pageKey, $sectionKey));
        Cache::forget("cms:page:{$pageKey}");

        if ($pageKey !== self::GLOBAL_PAGE_KEY) {
            Cache::forget("cms:page:".self::GLOBAL_PAGE_KEY);
        }
    }

    private function section(string $pageKey, string $sectionKey): ?PageSection
    {
        return Cache::remember(
            $this->cacheKey($pageKey, $sectionKey),
            now()->addMinutes(30),
            fn () => PageSection::query()
                ->where('page_key', $pageKey)
                ->where('section_key', $sectionKey)
                ->first()
        );
    }

    private function sectionsForPage(string $pageKey): array
    {
        return PageSection::query()
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
            ->all();
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

    private function resolveTreeValue(array $tree, string $path): mixed
    {
        if ($path === '') {
            return null;
        }

        if (array_key_exists($path, $tree)) {
            return $tree[$path];
        }

        $value = Arr::get($tree, $path);
        if ($value !== null) {
            return $value;
        }

        $segments = explode('.', $path);
        for ($length = count($segments) - 1; $length > 0; $length--) {
            $key = implode('.', array_slice($segments, 0, $length));

            if (! array_key_exists($key, $tree)) {
                continue;
            }

            $remainingPath = implode('.', array_slice($segments, $length));
            $node = $tree[$key];

            if ($remainingPath === '') {
                return $node;
            }

            if (is_array($node)) {
                if (array_key_exists($remainingPath, $node)) {
                    return $node[$remainingPath];
                }

                $nestedValue = Arr::get($node, $remainingPath);
                if ($nestedValue !== null) {
                    return $nestedValue;
                }
            }
        }

        return null;
    }

    private function cacheKey(string $pageKey, string $sectionKey): string
    {
        return "cms:section:{$pageKey}:{$sectionKey}";
    }
}
