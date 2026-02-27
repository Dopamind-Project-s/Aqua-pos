@extends('layouts.admin')

@section('content')
@include('admin.partials.flash-messages')
<div class="card"><div class="card-body">
    <div class="d-flex justify-content-between align-items-center mb-3"><h4 class="card-title mb-0">Product Details</h4><a href="{{ route('admin.products.index') }}" class="btn btn-outline-primary">Back</a></div>
    <div class="mb-3">
        <img src="{{ $product->image ? Storage::url($product->image) : asset('img/service-1.jpg') }}" alt="{{ $product->localized_name }}" class="rounded border" style="width: 180px; height: 180px; object-fit: cover;">
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
</div></div>
@endsection
