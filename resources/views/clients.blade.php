@extends('layouts.app')

@section('content')
<!-- Header Start -->
<div class="container-fluid bg-breadcrumb">
    <div class="container text-center py-5" style="max-width: 900px;">
        <h1 class="text-white display-3 mb-4 wow fadeInDown" data-wow-delay="0.1s"><span data-i18n="clients.pageTitle">Our Clients</span></h1>
        <ol class="breadcrumb justify-content-center mb-0 wow fadeInDown" data-wow-delay="0.3s">
            <li class="breadcrumb-item"><a href="{{ url('/') }}"><span data-i18n="breadcrumb.home">Home</span></a></li>
            <li class="breadcrumb-item"><a href="#"><span data-i18n="breadcrumb.pages">Pages</span></a></li>
            <li class="breadcrumb-item active text-primary"><span data-i18n="clients.pageCrumb">Clients</span></li>
        </ol>
    </div>
</div>
<!-- Header End -->

<!-- Clients Showcase Start -->
<section class="container-fluid clients-showcase py-5">
    <div class="container py-5">
        <div class="section-title mb-5 wow fadeInUp" data-wow-delay="0.1s">
            <div class="sub-style">
                <h4 class="sub-title px-3 mb-0"><span data-i18n="clients.pageEyebrow">Trusted Partnerships</span></h4>
            </div>
            <h2 class="display-5 mb-3"><span data-i18n="clients.pageHeading">Brands Growing with AQUA POS</span></h2>
            <p class="mb-0"><span data-i18n="clients.pageIntro">We work with restaurants and retail businesses that need speed, visibility, and stronger operational control across every branch.</span></p>
        </div>

        <div class="clients-showcase__stats wow fadeInUp" data-wow-delay="0.15s">
            <div class="clients-showcase__stat-card">
                <span class="clients-showcase__stat-number">{{ $clients->total() }}</span>
                <span class="clients-showcase__stat-label"><span data-i18n="clients.stat1">Active Client Brands</span></span>
            </div>
            <div class="clients-showcase__stat-card">
                <span class="clients-showcase__stat-number">24/7</span>
                <span class="clients-showcase__stat-label"><span data-i18n="clients.stat2">Operational Visibility</span></span>
            </div>
            <div class="clients-showcase__stat-card">
                <span class="clients-showcase__stat-number">Cloud</span>
                <span class="clients-showcase__stat-label"><span data-i18n="clients.stat3">Connected POS Platform</span></span>
            </div>
        </div>

        @if(($clients ?? collect())->count())
            <div class="row g-4 mt-1">
                @foreach($clients as $client)
                    <div class="col-6 col-md-4 col-lg-3 wow fadeInUp" data-wow-delay="0.2s">
                        <x-client-card :client="$client" :as-slide="false" />
                        @if($client->category)
                            <p class="small text-center mt-2 mb-0"><i class="fas fa-layer-group me-1"></i>{{ $client->category->localized_name }}</p>
                        @endif
                    </div>
                @endforeach
            </div>
            <div class="mt-4 d-flex justify-content-center">
                {{ $clients->links() }}
            </div>
        @else
            <div class="clients-showcase__empty text-center wow fadeInUp" data-wow-delay="0.2s">
                <i class="fas fa-building mb-3"></i>
                <h5 class="mb-2"><span data-i18n="clients.pageEmptyTitle">Client logos will appear here soon</span></h5>
                <p class="mb-0"><span data-i18n="clients.pageEmptySubtitle">Our newest collaborations are being prepared for publishing.</span></p>
            </div>
        @endif
    </div>
</section>
<!-- Clients Showcase End -->
@endsection
