@extends('layouts.app')

@push('styles')
<style>
    .products-page { background: linear-gradient(180deg, #f4f8ff 0%, #fff 100%); padding-top: clamp(5.2rem, 7vw, 6.6rem); }
    .products-hero { background: linear-gradient(130deg, #0f2e5f 0%, #1867bf 58%, #3f90f1 100%); color: #fff; border-radius: 0 0 32px 32px; }
    .products-section-card { border: 1px solid #e2ebfa; border-radius: 18px; background: #fff; box-shadow: 0 10px 24px rgba(13, 33, 67, .08); }
    .catalog-filter-chip { border: 1px solid #d6e4fa; color: #1a5bab; background: #f3f8ff; padding: .45rem .9rem; border-radius: 999px; text-decoration: none; font-weight: 700; font-size: 13px; }
    .catalog-filter-chip.active { background: #1f67c0; color: #fff; border-color: transparent; }
    .product-card { border: 1px solid #e2ebfa; border-radius: 18px; overflow: hidden; background: #fff; box-shadow: 0 10px 24px rgba(13,33,67,.08); height: 100%; transition: .25s ease; }
    .product-card:hover { transform: translateY(-4px); box-shadow: 0 14px 32px rgba(13,33,67,.14); }
    .product-card-media { position: relative; }
    .product-card img { width: 100%; height: 220px; object-fit: cover; }
    .product-open-float { position: absolute; top: 12px; inset-inline-end: 12px; }
    .product-price { font-weight: 800; color: #125ab0; }
    .product-actions { display: flex; gap: .5rem; flex-wrap: wrap; }
    .value-pill { border: 1px dashed #bfd5f6; background: #f5f9ff; border-radius: 14px; padding: 1rem; }

    body:not(.dark-mode) .products-hero {
        background: #EAF0F8 !important;
        background-image: none !important;
        color: #0d2344 !important;
    }

    body:not(.dark-mode) .products-hero h1,
    body:not(.dark-mode) .products-hero p {
        color: #0d2344 !important;
        text-shadow: none !important;
    }

    body:not(.dark-mode) .products-hero .page-hero__badge {
        background: rgba(13, 35, 68, .08) !important;
        border-color: rgba(13, 35, 68, .14) !important;
        color: #0d2344 !important;
    }

    body.dark-mode .products-page { background: linear-gradient(180deg, #0e1728 0%, #0b1420 100%); }
    body.dark-mode .products-section-card,
    body.dark-mode .product-card,
    body.dark-mode .value-pill { background: #121c2c; border-color: #2a3d5a; color: #dbe8fd; }
    body.dark-mode .product-card,
    body.dark-mode .product-card:hover { border-color: transparent !important; }
    body.dark-mode .products-hero .badge {
        background: rgba(255, 255, 255, .14) !important;
        border: 1px solid rgba(255, 255, 255, .28) !important;
        color: #fff !important;
    }
    body.dark-mode .product-card h3,
    body.dark-mode .products-section-card h5,
    body.dark-mode .products-section-card label,
    body.dark-mode .product-card .small:not(.text-muted) { color: #f4f8ff !important; }
    body.dark-mode .product-price { color: #8cc7ff !important; }
    body.dark-mode .text-muted { color: #aac2e4 !important; }
    body.dark-mode .products-page .form-control,
    body.dark-mode .products-page .form-select {
        background-color: #f8fbff !important;
        color: #0f172a !important;
        border-color: #6ed5ef !important;
    }
</style>
@endpush

@section('content')
<div class="products-page">
    @include('partials.page-hero', [
        'offset' => false,
        'class' => 'products-hero mb-4',
        'icon' => 'fas fa-box-open',
        'badge' => 'AQUA POS SUITE',
        'title' => 'Powerful Products for Retail & Restaurants',
        'titleI18n' => 'products.title',
        'subtitle' => 'Explore a modular product ecosystem covering sales, operations, finance, and growth across every branch.',
        'subtitleI18n' => 'products.subtitle',
    ])

    <section class="pb-5">
        <div class="container">
            <div class="products-section-card p-4 mb-4">
                <form method="GET" class="row g-3 align-items-end">
                    <div class="col-lg-4">
                        <label class="form-label fw-semibold" data-i18n="products.search">Search</label>
                        <input type="text" name="search" value="{{ $search }}" class="form-control" placeholder="Product name or keyword" data-i18n-placeholder="products.searchPlaceholder">
                    </div>
                    <div class="col-lg-3">
                        <label class="form-label fw-semibold" data-i18n="products.sort">Sort</label>
                        <select name="sort" class="form-select">
                            <option value="featured" @selected($sort==='featured') data-i18n="products.sortFeatured">Featured</option>
                            <option value="newest" @selected($sort==='newest') data-i18n="products.sortNewest">Newest</option>
                            <option value="price_low" @selected($sort==='price_low') data-i18n="products.sortPriceLow">Price: Low to High</option>
                            <option value="price_high" @selected($sort==='price_high') data-i18n="products.sortPriceHigh">Price: High to Low</option>
                        </select>
                    </div>
                    <div class="col-lg-5 d-flex gap-2">
                        <button class="btn btn-primary px-4" type="submit" data-i18n="products.apply">Apply</button>
                        <a href="{{ route('products') }}" class="btn btn-outline-primary" data-i18n="products.clear">Clear</a>
                        <div class="ms-auto text-muted small align-self-center">{{ $products->total() }} <span data-i18n="products.items">products</span></div>
                    </div>
                </form>
                <hr>
                <div class="d-flex flex-wrap gap-2">
                    <a href="{{ route('products', array_filter(['search' => $search, 'sort' => $sort])) }}" class="catalog-filter-chip {{ $selectedCategory === '' ? 'active' : '' }}" data-i18n="products.all">All</a>
                    @foreach($categories as $category)
                        <a href="{{ route('products', array_filter(['category' => $category->slug, 'search' => $search, 'sort' => $sort])) }}" class="catalog-filter-chip {{ $selectedCategory === $category->slug ? 'active' : '' }}">{{ $category->localized_name }}</a>
                    @endforeach
                </div>
            </div>

            <div class="row g-4">
                @forelse($products as $product)
                    <div class="col-md-6 col-xl-4">
                        <article class="product-card">
                            <div class="product-card-media">
                                <img src="{{ $product->image ? public_storage_url($product->image) : asset('img/service-1.jpg') }}" alt="{{ $product->localized_name }}">
                                <a href="{{ route('products.show', $product->slug) }}" class="btn btn-light btn-sm rounded-pill product-open-float" data-i18n="products.openShow">Open Product Page</a>
                            </div>
                            <div class="p-3 d-flex flex-column h-100">
                                <div class="d-flex justify-content-between align-items-start gap-2 mb-2">
                                    <h3 class="h5 mb-0">{{ $product->localized_name }}</h3>
                                    @if($product->is_featured)<span class="badge bg-warning text-dark" data-i18n="products.featured">Featured</span>@endif
                                </div>
                                <p class="text-muted small mb-2">{{ $product->localized_tagline ?: $product->localized_short_description }}</p>
                                <p class="small mb-3"><i class="fas fa-folder-open me-1"></i>{{ $product->category?->localized_name }}</p>
                                @if(!is_null($product->price))
                                    <p class="product-price mb-3">{{ $product->price_note ?: 'Starting from' }} {{ number_format((float) $product->price, 0) }}</p>
                                @endif
                                <div class="product-actions mt-auto">
                                    <a href="{{ route('products.show', $product->slug) }}" class="btn btn-primary rounded-pill w-100" data-i18n="products.openShow"><i class="fas fa-arrow-up-right-from-square me-1"></i>Open Product Page</a>
                                    <a href="{{ route('products.show', $product->slug) }}" class="btn btn-outline-primary rounded-pill w-100" data-i18n="products.viewDetails">View Details</a>
                                </div>
                            </div>
                        </article>
                    </div>
                @empty
                    <div class="col-12"><div class="alert alert-info" data-i18n="products.empty">No active products available right now.</div></div>
                @endforelse
            </div>

            <div class="products-section-card p-3 mt-4">
                {{ $products->onEachSide(1)->links() }}
            </div>
        </div>
    </section>
</div>
@endsection
