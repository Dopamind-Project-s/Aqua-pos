<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Category;
use App\Models\Product;
use App\Models\Post;

class HomeController extends Controller
{
    public function index()
    {
        $clients = Client::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name_en')
            ->take(12)
            ->get();

        $featuredProducts = Product::query()
            ->where('is_active', true)
            ->whereNull('deleted_at')
            ->orderByDesc('is_featured')
            ->orderBy('sort_order')
            ->latest()
            ->take(8)
            ->get();

        $featuredCategories = Category::query()
            ->where('is_active', true)
            ->whereNull('deleted_at')
            ->withCount(['products' => fn ($query) => $query->where('is_active', true)->whereNull('deleted_at')])
            ->orderBy('sort_order')
            ->take(8)
            ->get();

        $homePosts = Post::query()
            ->with('category')
            ->whereIn('type', ['blog', 'news'])
            ->where('status', 'published')
            ->orderByDesc('published_at')
            ->orderByDesc('id')
            ->take(6)
            ->get();

        return view('home', compact('clients', 'featuredProducts', 'featuredCategories', 'homePosts'));
    }
}
