<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\View\View;

class CategoryCatalogController extends Controller
{
    public function show(Category $category): View
    {
        abort_if(! $category->is_active || $category->deleted_at, 404);

        $category->load([
            'products' => fn ($query) => $query
                ->where('is_active', true)
                ->whereNull('deleted_at')
                ->orderByDesc('is_featured')
                ->orderBy('sort_order')
                ->latest(),
            'clients' => fn ($query) => $query
                ->where('is_active', true)
                ->orderBy('sort_order')
                ->orderBy('name_en'),
        ]);

        $relatedProducts = Product::query()
            ->where('is_active', true)
            ->whereNull('deleted_at')
            ->where('category_id', $category->id)
            ->count();

        return view('categories.show', compact('category', 'relatedProducts'));
    }
}
