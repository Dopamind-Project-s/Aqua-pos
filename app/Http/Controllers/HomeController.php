<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Client;
use App\Models\Post;
use App\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Throwable;

class HomeController extends Controller
{
    public function index()
    {
        $clients = $this->safeCollectionQuery(
            'clients',
            fn () => Client::query()
                ->where('is_active', true)
                ->orderBy('sort_order')
                ->orderBy('name_en')
                ->take(12)
                ->get(),
        );

        $featuredProducts = $this->safeCollectionQuery(
            'featured_products',
            fn () => Product::query()
                ->where('is_active', true)
                ->whereNull('deleted_at')
                ->orderByDesc('is_featured')
                ->orderBy('sort_order')
                ->latest()
                ->take(8)
                ->get(),
        );

        $featuredCategories = $this->safeCollectionQuery(
            'featured_categories',
            fn () => Category::query()
                ->where('is_active', true)
                ->whereNull('deleted_at')
                ->withCount(['products' => fn ($query) => $query->where('is_active', true)->whereNull('deleted_at')])
                ->orderBy('sort_order')
                ->take(8)
                ->get(),
        );

        $homePosts = $this->safeCollectionQuery(
            'home_posts',
            fn () => Post::query()
                ->with('category')
                ->whereIn('type', ['blog', 'news'])
                ->where('status', 'published')
                ->orderByDesc('published_at')
                ->orderByDesc('id')
                ->take(6)
                ->get(),
        );

        return view('home', compact('clients', 'featuredProducts', 'featuredCategories', 'homePosts'));
    }

    /**
     * Prevent optional home sections from taking down the full page.
     */
    private function safeCollectionQuery(string $section, callable $query): Collection
    {
        try {
            $result = $query();

            return $result instanceof Collection ? $result : collect($result);
        } catch (Throwable $exception) {
            Log::warning('Home section failed to load.', [
                'section' => $section,
                'error' => $exception->getMessage(),
            ]);

            return collect();
        }
    }
}
