<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Client;
use App\Models\Partner;
use App\Models\Post;
use App\Models\Product;
use App\Models\ServiceRequest;
use App\Models\SiteSetting;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $setting = SiteSetting::query()->first();

        $stats = [
            'categories' => Category::query()->count(),
            'products' => Product::query()->count(),
            'posts' => Post::query()->count(),
            'partners' => Partner::query()->count(),
            'clients' => Client::query()->count(),
            'requests' => ServiceRequest::query()->count(),
            'open_requests' => ServiceRequest::query()->whereIn('status', ['new', 'in_progress'])->count(),
        ];

        $leadStats = [
            'today' => ServiceRequest::query()->whereDate('created_at', now()->toDateString())->count(),
            'last_7_days' => ServiceRequest::query()->where('created_at', '>=', now()->subDays(7))->count(),
            'last_30_days' => ServiceRequest::query()->where('created_at', '>=', now()->subDays(30))->count(),
        ];

        $leadByType = ServiceRequest::query()
            ->selectRaw('type, COUNT(*) as total')
            ->groupBy('type')
            ->orderByDesc('total')
            ->get();

        $leadBySourcePage = ServiceRequest::query()
            ->selectRaw('source_page, COUNT(*) as total')
            ->whereNotNull('source_page')
            ->groupBy('source_page')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        $trackingMethod = $setting?->tracking_method ?? ($setting?->gtm_container_id ? 'gtm' : 'none');
        $trackingIsValid = match ($trackingMethod) {
            'ga4' => (bool) preg_match('/^G-[A-Z0-9]+$/', (string) $setting?->ga4_measurement_id),
            'gtm' => (bool) preg_match('/^GTM-[A-Z0-9]+$/', (string) $setting?->gtm_container_id),
            'none' => true,
            default => false,
        };
        $trackingStatus = [
            'method' => $trackingMethod,
            'valid' => $trackingIsValid,
        ];

        return view('admin.dashboard', compact(
            'stats',
            'leadStats',
            'leadByType',
            'leadBySourcePage',
            'trackingStatus'
        ));
    }
}
