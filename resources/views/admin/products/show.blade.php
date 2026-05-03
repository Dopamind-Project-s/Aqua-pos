@extends('layouts.admin')

@section('content')
@include('admin.partials.flash-messages')
<div class="card"><div class="card-body">
    <div class="d-flex justify-content-between align-items-center mb-3"><h4 class="card-title mb-0">Product Details</h4><a href="{{ route('admin.products.index') }}" class="btn btn-outline-primary">Back</a></div>
    <div class="mb-3">
        <img src="{{ $product->image ? public_storage_url($product->image) : asset('img/service-1.jpg') }}" alt="{{ $product->localized_name }}" class="rounded border" style="width: 180px; height: 180px; object-fit: cover;">
    </div>
    <div class="table-responsive"><table class="table mb-0 align-middle"><tbody>
        <tr><th>Name (Displayed)</th><td>{{ $product->localized_name }}</td></tr>
        <tr><th>Name (AR)</th><td>{{ $product->name_ar ?: '-' }}</td></tr>
        <tr><th>Name (EN)</th><td>{{ $product->name_en ?: '-' }}</td></tr>
        <tr><th>Category</th><td>{{ $product->category?->localized_name ?? '-' }}</td></tr>
        <tr><th>Slug</th><td>{{ $product->slug }}</td></tr>
        <tr><th>Tagline</th><td>{{ $product->localized_tagline ?: '-' }}</td></tr>
        <tr><th>Sort Order</th><td>{{ $product->sort_order }}</td></tr>
        <tr><th>Status</th><td><span class="badge {{ $product->is_active ? 'bg-success' : 'bg-secondary' }}">{{ $product->is_active ? 'Active' : 'Inactive' }}</span></td></tr>
    </tbody></table></div>

    @if($product->images->isNotEmpty())
        <hr>
        <h6 class="mb-3">Gallery Images</h6>
        <div class="row g-3">
            @foreach($product->images->sortBy('sort_order') as $image)
                <div class="col-md-4 col-lg-3">
                    <div class="border rounded p-2 h-100">
                        <img src="{{ public_storage_url($image->image) }}" alt="{{ $image->alt ?: $product->localized_name }}" class="rounded border mb-2" style="width:100%;height:140px;object-fit:cover;">
                        <div class="small text-muted">Sort: {{ $image->sort_order }}</div>
                        <div class="small">Alt: {{ $image->alt ?: '-' }}</div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div></div>
@endsection
