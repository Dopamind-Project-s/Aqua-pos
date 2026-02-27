<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ProductCatalogController extends Controller
{
    public function index(Request $request): View
    {
        $categorySlug = (string) $request->query('category', '');

        $categories = Category::query()
            ->where('is_active', true)
            ->whereNull('deleted_at')
            ->whereHas('products', fn ($query) => $query->where('is_active', true)->whereNull('deleted_at'))
            ->withCount(['products' => fn ($query) => $query->where('is_active', true)->whereNull('deleted_at')])
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        $products = Product::query()
            ->with(['category'])
            ->where('is_active', true)
            ->whereNull('deleted_at')
            ->whereHas('category', fn ($query) =>
                $query->where('is_active', true)->whereNull('deleted_at')
            )
            ->when($categorySlug !== '', fn ($query) =>
                $query->whereHas('category', fn ($q) => $q->where('slug', $categorySlug))
            )
            ->orderByDesc('is_featured')
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('products', [
            'products' => $products,
            'categories' => $categories,
            'selectedCategory' => $categorySlug,
        ]);
    }

    public function show(Product $product): View
    {
        abort_unless($product->is_active && is_null($product->deleted_at), 404);

        $product->load(['category', 'images']);

        $relatedProducts = Product::query()
            ->where('is_active', true)
            ->whereNull('deleted_at')
            ->where('id', '!=', $product->id)
            ->where('category_id', $product->category_id)
            ->latest()
            ->take(4)
            ->get();

        return view('products-show', [
            'product' => $product,
            'relatedProducts' => $relatedProducts,
        ]);
    }
}
