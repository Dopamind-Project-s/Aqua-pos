@extends('layouts.app')

@section('content')
<div class="container-fluid bg-breadcrumb">
    <div class="container text-center py-5" style="max-width: 900px;">
        <h1 class="text-white display-4 mb-3">{{ $category->localized_name }}</h1>
        <p class="text-white mb-0">{{ \Illuminate\Support\Str::limit($category->localized_description ?: 'Specialized category with ready-to-deploy POS workflows.', 160) }}</p>
    </div>
</div>

<section class="container-fluid category-single py-5">
    <div class="container py-5">
        <div class="row g-5 align-items-center mb-4">
            <div class="col-lg-5">
                <img src="{{ $category->image_url }}" alt="{{ $category->localized_name }}" class="img-fluid shadow-sm w-100 category-single__hero-img">
            </div>
            <div class="col-lg-7">
                <h2 class="display-6 mb-3">{{ $category->localized_name }}</h2>
                <p class="mb-3">{{ $category->localized_description ?: 'This category is designed for high-performance operations with integrated sales, inventory, and branch visibility.' }}</p>
                <div class="d-flex flex-wrap gap-3">
                    <div class="category-single__meta"><strong>{{ $relatedProducts }}</strong> Products</div>
                    <div class="category-single__meta"><strong>{{ $category->clients->count() }}</strong> Client Brands</div>
                </div>
            </div>
        </div>

        <div class="section-title mb-4">
            <div class="sub-style"><h4 class="sub-title px-3 mb-0">Category Products</h4></div>
            <h3 class="mb-2">Products under {{ $category->localized_name }}</h3>
        </div>

        <div class="row g-4">
            @forelse($category->products as $product)
                <div class="col-md-6 col-lg-4">
                    <div class="category-single__product-card h-100">
                        <img src="{{ $product->image_url }}" alt="{{ $product->localized_name }}" class="w-100 rounded-3 mb-3 category-single__product-img">
                        <h5>{{ $product->localized_name }}</h5>
                        <p class="mb-3">{{ \Illuminate\Support\Str::limit($product->localized_short_description ?: $product->localized_description ?: 'Discover full product capabilities.', 95) }}</p>
                        <a href="{{ route('products.show', $product->slug) }}" class="btn btn-sm btn-primary rounded-pill px-3">View Product</a>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center text-muted">No products available for this category yet.</div>
            @endforelse
        </div>

        @if($category->clients->count())
            <div class="category-single__clients-strip mt-5">
                <p class="mb-3 small text-uppercase fw-semibold">Clients in this category</p>
                <div class="row g-3 align-items-stretch">
                    @foreach($category->clients as $client)
                        <div class="col-6 col-md-3">
                            <div class="category-single__client-mini h-100">
                                <img src="{{ $client->logo_url }}" alt="{{ $client->localized_name }}" class="category-single__client-logo">
                                <h6 class="mb-1 mt-2">{{ $client->localized_name }}</h6>
                                <small class="text-muted">{{ \Illuminate\Support\Str::limit($client->localized_description ?: 'A trusted AQUA POS client.', 60) }}</small>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</section>
@endsection
