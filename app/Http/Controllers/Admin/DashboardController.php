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

        $trackingChecklist = [
            'GTM container configured' => !empty($setting?->gtm_container_id),
            'GA4 measurement configured' => !empty($setting?->ga4_measurement_id),
            'Google Ads conversion configured' => !empty($setting?->google_ads_conversion_id) && !empty($setting?->google_ads_conversion_label),
            'Meta Pixel ID configured' => !empty($setting?->meta_pixel_id),
            'Google site verification configured' => !empty($setting?->google_site_verification),
            'Search Console property configured' => !empty($setting?->search_console_property),
            'Clarity project configured' => !empty($setting?->ms_clarity_project_id),
        ];

        $trackingProgress = [
            'done' => collect($trackingChecklist)->filter()->count(),
            'total' => count($trackingChecklist),
        ];

        return view('admin.dashboard', compact(
            'stats',
            'leadStats',
            'leadByType',
            'leadBySourcePage',
            'trackingChecklist',
            'trackingProgress'
        ));
    }
}
