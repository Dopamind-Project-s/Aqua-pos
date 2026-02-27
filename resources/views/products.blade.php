@extends('layouts.app')

@push('styles')
<style>
    .products-page {
        background: radial-gradient(circle at top right, #eef5ff 0%, #f7fbff 52%, #ffffff 100%);
        padding-top: clamp(5.1rem, 7vw, 6.5rem);
    }

    .products-hero {
        background: linear-gradient(132deg, #0f2850 0%, #125eb4 58%, #2f84e7 100%);
        color: #fff;
        border-radius: 0 0 24px 24px;
        position: relative;
        overflow: hidden;
    }

    .products-hero::after {
        content: "";
        position: absolute;
        width: 340px;
        height: 340px;
        border-radius: 50%;
        top: -145px;
        right: -115px;
        background: rgba(255,255,255,.14);
    }

    .products-hero .container { position: relative; z-index: 2; }

    .products-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        border-radius: 999px;
        padding: 8px 14px;
        border: 1px solid rgba(255,255,255,.28);
        background: rgba(255,255,255,.15);
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
    }

    .products-toolbar {
        border: 1px solid #dfe9f8;
        border-radius: 16px;
        padding: 14px;
        background: #fff;
        box-shadow: 0 10px 22px rgba(13, 33, 67, .08);
    }

    .product-filter-chip {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        border-radius: 999px;
        padding: 8px 13px;
        border: 1px solid #d5e4f8;
        background: #f3f8ff;
        color: #1854a5;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
    }

    .product-filter-chip.active {
        background: linear-gradient(135deg, #145bb0, #2b83e5);
        border-color: transparent;
        color: #fff;
    }

    .product-catalog-card {
        border: 1px solid #dfeaf9;
        border-radius: 18px;
        background: #fff;
        box-shadow: 0 10px 24px rgba(13, 33, 67, .08);
        overflow: hidden;
        transition: transform .2s ease, box-shadow .2s ease;
    }

    .product-catalog-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 14px 28px rgba(13, 33, 67, .12);
    }

    .product-catalog-image {
        width: 100%;
        height: 220px;
        object-fit: cover;
    }

    .product-catalog-body { padding: 18px; }
    .product-catalog-title { font-size: 1.06rem; font-weight: 800; color: #123261; }
    .product-catalog-tagline { color: #4f6788; font-size: 14px; }
    .product-catalog-price { font-weight: 800; color: #0f5ab0; }

    body.dark-mode .products-page { background: linear-gradient(180deg, #0f1726 0%, #0b1420 100%); }
    body.dark-mode .products-toolbar,
    body.dark-mode .product-catalog-card {
        background: #121c2c;
        border-color: #253650;
        box-shadow: 0 12px 24px rgba(0,0,0,.34);
    }

    body.dark-mode .product-catalog-title,
    body.dark-mode .products-toolbar h5,
    body.dark-mode .products-toolbar p,
    body.dark-mode .product-catalog-tagline,
    body.dark-mode .product-catalog-price {
        color: #dce8fb !important;
    }

    body.dark-mode .product-filter-chip { background: #1b2940; border-color: #2a3f5d; color: #9ec5ff; }
    body.dark-mode .product-filter-chip.active { background: linear-gradient(135deg, #1f63bc, #2a79df); color: #fff; }
</style>
@endpush

@section('content')
<div class="products-page">
<section class="products-hero py-5 mb-4">
    <div class="container py-4 text-center">
        <span class="products-badge mb-3"><i class="fas fa-box-open"></i><span data-i18n="products.badge">Product Catalog</span></span>
        <h1 class="display-5 fw-bold mb-3" data-i18n="products.title">Powerful Products for Retail & Restaurants</h1>
        <p class="lead mb-0" data-i18n="products.subtitle">Explore our complete product lineup designed to optimize sales, inventory, and multi-branch operations.</p>
    </div>
</section>

<section class="pb-5">
    <div class="container">
        <div class="products-toolbar mb-4">
            <div class="d-flex justify-content-between flex-wrap gap-2 align-items-center mb-3">
                <h5 class="mb-0" data-i18n="products.filterTitle">Filter by Category</h5>
                <p class="mb-0 text-muted"><span data-i18n="products.totalLabel">Total Products:</span> {{ $products->total() }}</p>
            </div>
            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('products') }}" class="product-filter-chip {{ $selectedCategory === '' ? 'active' : '' }}"><i class="fas fa-layer-group"></i><span data-i18n="products.allCategories">All Categories</span></a>
                @foreach($categories as $category)
                    <a href="{{ route('products', ['category' => $category->slug]) }}" class="product-filter-chip {{ $selectedCategory === $category->slug ? 'active' : '' }}">
                        <i class="fas fa-tag"></i>
                        <span>{{ $category->name }}</span>
                    </a>
                @endforeach
            </div>
        </div>

        <div class="row g-4">
            @forelse($products as $product)
                <div class="col-12 col-md-6 col-xl-4">
                    <article class="product-catalog-card h-100">
                        <img src="{{ $product->image ? Storage::url($product->image) : asset('img/service-1.jpg') }}" class="product-catalog-image" alt="{{ $product->name }}">
                        <div class="product-catalog-body d-flex flex-column h-100">
                            <h3 class="product-catalog-title mb-2">{{ $product->name }}</h3>
                            <p class="mb-2 product-catalog-tagline">{{ $product->tagline ?: $product->short_description }}</p>
                            <p class="mb-3 text-muted"><i class="fas fa-folder-open me-1"></i>{{ $product->category?->name }}</p>
                            @if(!is_null($product->price))
                                <p class="product-catalog-price mb-3">{{ $product->price_note ?: 'Starting from' }} {{ number_format((float)$product->price, 0) }}</p>
                            @endif
                            <a href="{{ route('products.show', $product->slug) }}" class="btn btn-outline-primary rounded-pill mt-auto"><i class="fas fa-arrow-right me-2"></i><span data-i18n="products.viewDetails">View Details</span></a>
                        </div>
                    </article>
                </div>
            @empty
                <div class="col-12"><div class="alert alert-info" data-i18n="products.empty">No active products available right now.</div></div>
            @endforelse
        </div>

        <div class="mt-4">{{ $products->links() }}</div>
    </div>
</section>
</div>
@endsection
