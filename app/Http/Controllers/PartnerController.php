<?php

namespace App\Http\Controllers;

use App\Models\Partner;

class PartnerController extends Controller
{
    public function index()
    {
        $partners = Partner::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name_en')
            ->paginate(12);

        $mapPartners = Partner::query()
            ->where('is_active', true)
            ->whereNotNull('map_latitude')
            ->whereNotNull('map_longitude')
            ->orderBy('sort_order')
            ->orderBy('name_en')
            ->get()
            ->map(fn (Partner $partner): array => [
                'nameAr' => $partner->name_ar ?: $partner->name_en ?: $partner->name,
                'nameEn' => $partner->name_en ?: $partner->name_ar ?: $partner->name,
                'locationAr' => $partner->map_location_ar ?: $partner->map_location_en,
                'locationEn' => $partner->map_location_en ?: $partner->map_location_ar,
                'latitude' => (float) $partner->map_latitude,
                'longitude' => (float) $partner->map_longitude,
                'contactUrl' => route('contact', ['partner' => $partner->slug]),
            ]);

        return view('partners.index', [
            'partners' => $partners,
            'mapPartners' => $mapPartners,
            'metaTitle' => 'Our Trusted Partners | Aqua POS',
            'metaDescription' => 'Meet the trusted partners that empower Aqua POS with world-class integrations and business collaboration.',
        ]);
    }
}
