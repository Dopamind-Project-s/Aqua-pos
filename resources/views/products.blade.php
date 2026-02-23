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

        <div class="row g-4">
            @forelse($products as $product)
                <div class="col-md-6 col-lg-4 col-xl-3">
                    <div class="service-item rounded h-100">
                        <div class="service-img rounded-top">
                            <img src="{{ $product->image ? Storage::url($product->image) : asset('img/service-1.jpg') }}" class="img-fluid rounded-top w-100" style="height: 220px; object-fit: cover;" alt="{{ $product->name }}">
                        </div>
                        <div class="service-content rounded-bottom bg-light p-4 h-100">
                            <div class="service-content-inner">
                                <h5 class="mb-3">{{ $product->name }}</h5>
                                <p class="mb-2"><strong>Category:</strong> {{ $product->category?->name }}</p>
                                @if($product->short_description)
                                    <p class="mb-2">{{ $product->short_description }}</p>
                                @endif
                                @if(!is_null($product->price))
                                    <p class="mb-0 text-primary fw-bold">{{ number_format((float)$product->price, 2) }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12"><div class="alert alert-info">No active products available right now.</div></div>
            @endforelse
        </div>

        <div class="mt-4">{{ $products->links() }}</div>
    </div>
</div>
@endsection
