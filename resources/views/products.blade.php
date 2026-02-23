@extends('layouts.app')

@section('content')
<div class="container-fluid bg-breadcrumb">
    <div class="container text-center py-5" style="max-width: 900px;">
        <h3 class="text-white display-3 mb-4">Products</h3>
        <ol class="breadcrumb justify-content-center mb-0">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
            <li class="breadcrumb-item active text-primary">Products</li>
        </ol>
    </div>
</div>

<div class="container-fluid service py-5">
    <div class="container py-5">
        <div class="section-title mb-5">
            <div class="sub-style"><h4 class="sub-title px-3 mb-0">Active Catalog</h4></div>
            <h1 class="display-3 mb-4">Our Active Products</h1>
        </div>

        <div class="row g-4 product-grid">
            @forelse($products as $product)
                <div class="col-12 col-md-6 col-xl-4 product-grid-col">
                    <article class="product-grid-card service-item rounded h-100">
                        <div class="service-img rounded-top product-grid-media-wrap">
                            <img
                                src="{{ $product->image ? Storage::url($product->image) : asset('img/service-1.jpg') }}"
                                class="img-fluid rounded-top w-100 product-grid-media"
                                alt="{{ $product->name }}"
                                loading="lazy"
                            >
                        </div>

                        <div class="service-content rounded-bottom bg-light p-4 h-100 d-flex">
                            <div class="service-content-inner product-grid-content d-flex flex-column w-100">
                                <h5 class="mb-3 product-grid-title">{{ $product->name }}</h5>
                                <p class="mb-2 product-grid-category"><strong>Category:</strong> {{ $product->category?->name }}</p>

                                @if($product->short_description)
                                    <p class="mb-3 product-grid-description">{{ $product->short_description }}</p>
                                @else
                                    <p class="mb-3 product-grid-description text-muted">No description available.</p>
                                @endif

                                @if(!is_null($product->price))
                                    <p class="mb-0 mt-auto text-primary fw-bold product-grid-price">{{ number_format((float)$product->price, 2) }}</p>
                                @endif
                            </div>
                        </div>
                    </article>
                </div>
            @empty
                <div class="col-12"><div class="alert alert-info">No active products available right now.</div></div>
            @endforelse
        </div>

        <div class="mt-4">{{ $products->links() }}</div>
    </div>
</div>
@endsection
