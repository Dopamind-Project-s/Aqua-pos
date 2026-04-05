<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PageSection;
use App\Support\DynamicContent;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

class DynamicContentController extends Controller
{
    public function index(Request $request, DynamicContent $dynamicContent): JsonResponse
    {
        $validated = $request->validate([
            'page_key' => ['required', 'string', 'max:120'],
        ]);

        return response()->json([
            'page_key' => $validated['page_key'],
            'sections' => $dynamicContent->page($validated['page_key']),
        ]);
    }

    public function save(Request $request, DynamicContent $dynamicContent): JsonResponse
    {
        $validated = $request->validate([
            'page_key' => ['required', 'string', 'max:120'],
            'changes' => ['required', 'array'],
            'changes.*.section_key' => ['required', 'string', 'max:120'],
            'changes.*.content_json' => ['nullable', 'array'],
            'changes.*.style_json' => ['nullable', 'array'],
            'changes.*.is_visible' => ['nullable', 'boolean'],
            'changes.*.sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        foreach ($validated['changes'] as $change) {
            $section = PageSection::query()->firstOrNew([
                'page_key' => $validated['page_key'],
                'section_key' => $change['section_key'],
            ]);

            $section->content_json = array_merge($section->content_json ?? [], $change['content_json'] ?? []);
            $section->style_json = array_merge($section->style_json ?? [], $change['style_json'] ?? []);
            $section->is_visible = Arr::get($change, 'is_visible', $section->is_visible ?? true);
            $section->sort_order = Arr::get($change, 'sort_order', $section->sort_order ?? 0);
            $section->save();

            $dynamicContent->flush($validated['page_key'], $change['section_key']);
        }

        return response()->json(['status' => 'saved']);
    }

    public function uploadImage(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'image' => ['required', 'image', 'max:4096'],
        ]);

        $path = $validated['image']->store('cms', 'public');

        return response()->json([
            'path' => $path,
            'url' => Storage::disk('public')->url($path),
        ]);
    }
}
