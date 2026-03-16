<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Client;
use App\Models\Partner;
use App\Models\Post;
use App\Models\Product;
use App\Models\ServiceRequest;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'categories' => Category::query()->count(),
            'products' => Product::query()->count(),
            'posts' => Post::query()->count(),
            'partners' => Partner::query()->count(),
            'clients' => Client::query()->count(),
            'requests' => ServiceRequest::query()->count(),
            'open_requests' => ServiceRequest::query()->whereIn('status', ['new', 'in_progress'])->count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
