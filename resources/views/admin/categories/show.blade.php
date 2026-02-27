@extends('layouts.admin')

@section('content')
@include('admin.partials.flash-messages')
<div class="card"><div class="card-body">
    <div class="d-flex justify-content-between align-items-center mb-3"><h4 class="card-title mb-0">Category Details</h4><a href="{{ route('admin.categories.index') }}" class="btn btn-outline-primary">Back</a></div>
    <div class="table-responsive"><table class="table text-nowrap mb-0 align-middle">
        <tbody>
            <tr><th>Name (Displayed)</th><td>{{ $category->localized_name }}</td></tr>
            <tr><th>Name (AR)</th><td>{{ $category->name_ar ?: '-' }}</td></tr>
            <tr><th>Name (EN)</th><td>{{ $category->name_en ?: '-' }}</td></tr>
            <tr><th>Slug</th><td>{{ $category->slug }}</td></tr>
            <tr><th>Description (Default)</th><td>{{ $category->description ?: '-' }}</td></tr>
            <tr><th>Description (AR)</th><td>{{ $category->description_ar ?: '-' }}</td></tr>
            <tr><th>Description (EN)</th><td>{{ $category->description_en ?: '-' }}</td></tr>
            <tr><th>Sort Order</th><td>{{ $category->sort_order }}</td></tr>
            <tr><th>Status</th><td><span class="badge {{ $category->is_active ? 'bg-success' : 'bg-secondary' }}">{{ $category->is_active ? 'Active' : 'Inactive' }}</span></td></tr>
            <tr><th>Products</th><td>{{ $category->products_count ?? 0 }}</td></tr>
            <tr><th>Created At</th><td>{{ $category->created_at?->format('Y-m-d H:i') }}</td></tr>
        </tbody>
    </table></div>
</div></div>
@endsection
