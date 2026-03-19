<?php

namespace App\Http\Controllers;

use App\Models\Client;
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
            ->get();

        $featuredProducts = Product::query()
            ->where('is_active', true)
            ->whereNull('deleted_at')
            ->orderByDesc('is_featured')
            ->orderBy('sort_order')
            ->latest()
            ->take(8)
            ->get();

        $homePosts = Post::query()
            ->with('category')
            ->where('type', 'blog')
            ->where('status', 'published')
            ->orderByDesc('published_at')
            ->orderByDesc('id')
            ->take(3)
            ->get();

        return view('home', compact('clients', 'featuredProducts', 'homePosts'));
    }
}
