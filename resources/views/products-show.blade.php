@extends('layouts.app')

@push('styles')
<style>
    .product-show-page {
        background: radial-gradient(circle at top right, #eef5ff 0%, #f7fbff 52%, #ffffff 100%);
        padding-top: clamp(5.2rem, 7vw, 6.6rem);
    }

    .product-show-hero {
        background: linear-gradient(132deg, #0f2850 0%, #125eb4 58%, #2f84e7 100%);
        color: #fff;
        border-radius: 0 0 24px 24px;
    }

    .product-show-card {
        border: 1px solid #dfe9f8;
        border-radius: 20px;
        background: #fff;
        box-shadow: 0 12px 26px rgba(13, 33, 67, .08);
        overflow: hidden;
    }

    .product-show-image { width: 100%; height: 100%; min-height: 320px; object-fit: cover; }
    .product-feature-chip {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        border-radius: 999px;
        padding: 8px 12px;
        background: #edf5ff;
        border: 1px solid #d5e4f8;
        color: #1a5cab;
        font-size: 13px;
        font-weight: 700;
    }

    .product-related-card {
        border: 1px solid #dfe9f8;
        border-radius: 14px;
        background: #fff;
        padding: 14px;
        height: 100%;
    }

    body.dark-mode .product-show-page { background: linear-gradient(180deg, #0f1726 0%, #0b1420 100%); }
    body.dark-mode .product-show-card,
    body.dark-mode .product-related-card {
        background: #121c2c;
        border-color: #253650;
    }

    body.dark-mode .product-feature-chip { background: #1b2940; border-color: #2a3f5d; color: #9ec5ff; }
    body.dark-mode .product-show-card h1,
    body.dark-mode .product-show-card h2,
    body.dark-mode .product-show-card p,
    body.dark-mode .product-related-card h6,
    body.dark-mode .product-related-card p,
    body.dark-mode .product-related-card .text-muted { color: #dce8fb !important; }
</style>
@endpush

@section('content')
<div class="product-show-page">
<section class="product-show-hero py-5 mb-4">
    <div class="container py-4">
        <div class="d-flex flex-wrap gap-2 mb-2">
            <span class="badge bg-light text-dark">{{ $product->category?->name }}</span>
            @if($product->is_featured)
                <span class="badge bg-warning text-dark" data-i18n="products.featured">Featured</span>
            @endif
        </div>
        <h1 class="display-5 fw-bold mb-2">{{ $product->name }}</h1>
        <p class="lead mb-0">{{ $product->tagline ?: $product->short_description }}</p>
    </div>
</section>

<section class="pb-5">
    <div class="container">
        <div class="product-show-card mb-4">
            <div class="row g-0">
                <div class="col-lg-5">
                    <img class="product-show-image" src="{{ $product->image ? Storage::url($product->image) : asset('img/service-1.jpg') }}" alt="{{ $product->name }}">
                </div>
                <div class="col-lg-7 p-4 p-lg-5">
                    <h2 class="h3 mb-3" data-i18n="products.about">About this product</h2>
                    <p class="text-muted mb-4">{{ $product->description ?: $product->short_description }}</p>

                    @if(!empty($product->key_features))
                        <div class="d-flex flex-wrap gap-2 mb-4">
                            @foreach($product->key_features as $feature)
                                <span class="product-feature-chip"><i class="fas fa-check-circle"></i>{{ $feature }}</span>
                            @endforeach
                        </div>
                    @endif

                    @if($product->use_cases)
                        <h3 class="h6 mb-2" data-i18n="products.useCases">Use Cases</h3>
                        <p class="text-muted mb-4">{{ $product->use_cases }}</p>
                    @endif

                    <div class="d-flex flex-wrap gap-2 align-items-center">
                        @if(!is_null($product->price))
                            <strong class="text-primary">{{ $product->price_note ?: 'Starting from' }} {{ number_format((float)$product->price, 0) }}</strong>
                        @endif
                        <a href="{{ route('request-product-demo') }}" class="btn btn-primary rounded-pill"><i class="fas fa-calendar-check me-2"></i><span data-i18n="products.requestDemo">Request Demo</span></a>
                    </div>
                </div>
            </div>
        </div>

        @if($relatedProducts->isNotEmpty())
            <h3 class="h4 mb-3" data-i18n="products.related">Related Products</h3>
            <div class="row g-3">
                @foreach($relatedProducts as $related)
                    <div class="col-md-6 col-xl-3">
                        <article class="product-related-card">
                            <h6 class="mb-2">{{ $related->name }}</h6>
                            <p class="text-muted small mb-3">{{ $related->short_description }}</p>
                            <a href="{{ route('products.show', $related->slug) }}" class="btn btn-sm btn-outline-primary rounded-pill"><span data-i18n="products.viewDetails">View Details</span></a>
                        </article>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>
</div>
@endsection
