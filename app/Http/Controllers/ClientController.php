<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ClientController extends Controller
{
    public function index(Request $request): View
    {
        $selectedCategory = (string) $request->query('category', '');

        $categories = Category::query()
            ->where('is_active', true)
            ->whereNull('deleted_at')
            ->whereHas('clients', fn ($query) => $query->where('is_active', true))
            ->withCount(['clients' => fn ($query) => $query->where('is_active', true)])
            ->orderBy('sort_order')
            ->orderBy('name_en')
            ->get();

        $clients = Client::query()
            ->where('is_active', true)
            ->with('category')
            ->when(
                $selectedCategory === 'uncategorized',
                fn ($query) => $query->whereNull('category_id')
            )
            ->when(
                $selectedCategory !== '' && $selectedCategory !== 'uncategorized',
                fn ($query) => $query->whereHas('category', fn ($categoryQuery) => $categoryQuery->where('slug', $selectedCategory))
            )
            ->orderBy('sort_order')
            ->orderBy('name_en')
            ->paginate(12)
            ->withQueryString();

        $clientsByCategory = $clients->getCollection()->groupBy(fn ($client) => $client->category?->id ?? 'uncategorized');
        $uncategorizedCount = Client::query()->where('is_active', true)->whereNull('category_id')->count();

        return view('clients', compact('clients', 'categories', 'selectedCategory', 'clientsByCategory', 'uncategorizedCount'));
    }
}
