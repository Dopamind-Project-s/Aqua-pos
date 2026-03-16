@extends('layouts.app')

@section('content')
<!-- Header Start -->
<div class="container-fluid bg-breadcrumb">
    <div class="container text-center py-5" style="max-width: 900px;">
        <h1 class="text-white display-3 mb-4 wow fadeInDown" data-wow-delay="0.1s">Our Clients</h1>
        <ol class="breadcrumb justify-content-center mb-0 wow fadeInDown" data-wow-delay="0.3s">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="#">Pages</a></li>
            <li class="breadcrumb-item active text-primary">Clients</li>
        </ol>
    </div>
</div>
<!-- Header End -->

<!-- Clients Showcase Start -->
<section class="container-fluid clients-showcase py-5">
    <div class="container py-5">
        <div class="section-title mb-5 wow fadeInUp" data-wow-delay="0.1s">
            <div class="sub-style">
                <h4 class="sub-title px-3 mb-0">Trusted Partnerships</h4>
            </div>
            <h2 class="display-5 mb-3">Brands Growing with AQUA POS</h2>
            <p class="mb-0">We work with restaurants and retail businesses that need speed, visibility, and stronger operational control across every branch.</p>
        </div>

        <div class="clients-showcase__stats wow fadeInUp" data-wow-delay="0.15s">
            <div class="clients-showcase__stat-card">
                <span class="clients-showcase__stat-number">{{ ($clients ?? collect())->count() }}</span>
                <span class="clients-showcase__stat-label">Active Client Brands</span>
            </div>
            <div class="clients-showcase__stat-card">
                <span class="clients-showcase__stat-number">24/7</span>
                <span class="clients-showcase__stat-label">Operational Visibility</span>
            </div>
            <div class="clients-showcase__stat-card">
                <span class="clients-showcase__stat-number">Cloud</span>
                <span class="clients-showcase__stat-label">Connected POS Platform</span>
            </div>
        </div>

        @if(($clients ?? collect())->count())
            <div class="row g-4 mt-1">
                @foreach($clients as $client)
                    <div class="col-6 col-md-4 col-lg-3 wow fadeInUp" data-wow-delay="0.2s">
                        <x-client-card :client="$client" :as-slide="false" />
                    </div>
                @endforeach
            </div>
        @else
            <div class="clients-showcase__empty text-center wow fadeInUp" data-wow-delay="0.2s">
                <i class="fas fa-building mb-3"></i>
                <h5 class="mb-2">Client logos will appear here soon</h5>
                <p class="mb-0">Our newest collaborations are being prepared for publishing.</p>
            </div>
        @endif
    </div>
</section>
<!-- Clients Showcase End -->
@endsection
