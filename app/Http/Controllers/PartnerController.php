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
            ->orderBy('name')
            ->paginate(12);

        return view('partners.index', [
            'partners' => $partners,
            'metaTitle' => 'Our Trusted Partners | Aqua POS',
            'metaDescription' => 'Meet the trusted partners that empower Aqua POS with world-class integrations and business collaboration.',
        ]);
    }
}
