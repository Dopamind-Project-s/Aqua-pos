@extends('layouts.admin')

@section('content')
@include('admin.partials.flash-messages')
<div class="card"><div class="card-body">
    <div class="d-flex justify-content-between align-items-center mb-3"><h4 class="card-title mb-0">Products</h4><a href="{{ route('admin.products.create') }}" class="btn btn-primary">Create Product</a></div>
    <div class="table-responsive"><table class="table text-nowrap mb-0 align-middle">
        <thead class="text-dark fs-4"><tr><th>Image</th><th>Name</th><th>Category</th><th>Status</th><th class="text-end">Actions</th></tr></thead>
        <tbody>
        @forelse($products as $product)
            <tr>
                <td><img src="{{ $product->image ? Storage::url($product->image) : asset('img/service-1.jpg') }}" alt="{{ $product->name }}" class="rounded border" style="width:60px;height:60px;object-fit:cover;"></td>
                <td>{{ $product->name }}</td><td>{{ $product->category?->name ?? '-' }}</td>
                <td><span class="badge {{ $product->is_active ? 'bg-success' : 'bg-secondary' }}">{{ $product->is_active ? 'Active' : 'Inactive' }}</span></td>
                <td class="text-end"><a class="btn btn-sm btn-info" href="{{ route('admin.products.show',$product->id) }}">View</a> <a class="btn btn-sm btn-warning" href="{{ route('admin.products.edit',$product->id) }}">Edit</a> <form action="{{ route('admin.products.destroy',$product->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Soft delete this product?');">@csrf @method('DELETE')<button class="btn btn-sm btn-danger" type="submit">Delete</button></form></td>
            </tr>
        @empty
            <tr><td colspan="5" class="text-center">No products found.</td></tr>
        @endforelse
        </tbody>
    </table></div>
    {{ $products->links() }}
</div></div>
@endsection
