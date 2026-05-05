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
        $search = trim((string) $request->query('search', ''));
        $sort = (string) $request->query('sort', 'featured');

        $categories = Category::query()
            ->where('is_active', true)
            ->whereNull('deleted_at')
            ->whereHas('products', fn ($query) => $query->where('is_active', true)->whereNull('deleted_at'))
            ->withCount(['products' => fn ($query) => $query->where('is_active', true)->whereNull('deleted_at')])
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        $productsQuery = Product::query()
            ->with(['category'])
            ->where('is_active', true)
            ->whereNull('deleted_at')
            ->whereHas('category', fn ($query) => $query->where('is_active', true)->whereNull('deleted_at'))
            ->when($categorySlug !== '', fn ($query) => $query->whereHas('category', fn ($q) => $q->where('slug', $categorySlug)))
            ->when($search !== '', function ($query) use ($search): void {
                $query->where(function ($nested) use ($search): void {
                    $nested->where('name', 'like', "%{$search}%")
                        ->orWhere('name_ar', 'like', "%{$search}%")
                        ->orWhere('name_en', 'like', "%{$search}%")
                        ->orWhere('tagline', 'like', "%{$search}%")
                        ->orWhere('tagline_ar', 'like', "%{$search}%")
                        ->orWhere('tagline_en', 'like', "%{$search}%");
                });
            });

        match ($sort) {
            'price_low' => $productsQuery->orderBy('price'),
            'price_high' => $productsQuery->orderByDesc('price'),
            'newest' => $productsQuery->latest(),
            default => $productsQuery->orderByDesc('is_featured')->orderBy('sort_order')->latest(),
        };

        $products = $productsQuery
            ->paginate(9)
            ->withQueryString();

        return view('products.index', [
            'products' => $products,
            'categories' => $categories,
            'selectedCategory' => $categorySlug,
            'search' => $search,
            'sort' => $sort,
        ]);
    }

    public function show(Product $product): View
    {
        abort_unless($product->is_active && is_null($product->deleted_at), 404);

        $product->load([
            'category',
            'images' => fn ($query) => $query->orderBy('sort_order')->orderBy('id'),
        ]);

        $relatedProducts = Product::query()
            ->where('is_active', true)
            ->whereNull('deleted_at')
            ->where('id', '!=', $product->id)
            ->where('category_id', $product->category_id)
            ->orderByDesc('is_featured')
            ->orderBy('sort_order')
            ->latest()
            ->take(4)
            ->get();

        return view('products.show', [
            'product' => $product,
            'relatedProducts' => $relatedProducts,
        ]);
    }
}
