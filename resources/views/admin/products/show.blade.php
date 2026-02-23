@extends('layouts.admin')

@section('content')
@include('admin.partials.flexy-shell-start')
@include('admin.partials.flash-messages')
<div class="card"><div class="card-body">
    <div class="d-flex justify-content-between align-items-center mb-3"><h4 class="card-title mb-0">Product Details</h4><a href="{{ route('admin.products.index') }}" class="btn btn-outline-primary">Back</a></div>
    <div class="mb-3">
        <img src="{{ $product->image ? Storage::url($product->image) : asset('img/service-1.jpg') }}" alt="{{ $product->name }}" class="rounded border" style="width: 180px; height: 180px; object-fit: cover;">
    </div>
    <div class="table-responsive"><table class="table text-nowrap mb-0 align-middle"><tbody>
        <tr><th>Name</th><td>{{ $product->name }}</td></tr>
        <tr><th>Category</th><td>{{ $product->category?->name ?? '-' }}</td></tr>
        <tr><th>Slug</th><td>{{ $product->slug }}</td></tr>
        <tr><th>Status</th><td><span class="badge {{ $product->is_active ? 'bg-success' : 'bg-secondary' }}">{{ $product->is_active ? 'Active' : 'Inactive' }}</span></td></tr>
    </tbody></table></div>
</div></div>
@include('admin.partials.flexy-shell-end')
@endsection
