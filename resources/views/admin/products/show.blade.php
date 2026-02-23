@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4"><div class="row">@include('admin.partials.sidebar')
<main class="col-md-9 col-lg-10 p-4">
    <h2 class="mb-3">Product Details</h2>
    <div class="card"><div class="card-body">
        <p><strong>Name:</strong> {{ $product->name }}</p>
        <p><strong>Category:</strong> {{ $product->category?->name }}</p>
        <p><strong>Slug:</strong> {{ $product->slug }}</p>
        <p><strong>Status:</strong> {{ $product->is_active ? 'Active' : 'Inactive' }}</p>
        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Back</a>
    </div></div>
</main></div></div>
@endsection
