@extends('layouts.admin')

@section('content')
@include('admin.partials.flash-messages')

<div class="card mb-3"><div class="card-body">
    <form method="GET" class="row g-2 align-items-end">
        <div class="col-md-4"><label class="form-label">Search</label><input type="text" name="search" value="{{ $search }}" class="form-control" placeholder="Name or slug"></div>
        <div class="col-md-3"><label class="form-label">Category</label><select name="category_id" class="form-select"><option value="">All categories</option>@foreach($categories as $category)<option value="{{ $category->id }}" @selected($categoryId===$category->id)>{{ $category->localized_name }}</option>@endforeach</select></div>
        <div class="col-md-3"><label class="form-label">Status</label><select name="status" class="form-select"><option value="all" @selected($status==='all')>All</option><option value="active" @selected($status==='active')>Active</option><option value="inactive" @selected($status==='inactive')>Inactive</option></select></div>
        <div class="col-md-2 d-flex gap-2"><button class="btn btn-primary w-100" type="submit">Filter</button><a href="{{ route('admin.products.index') }}" class="btn btn-outline-primary w-100">Reset</a></div>
    </form>
</div></div>

<div class="card"><div class="card-body">
    <div class="d-flex justify-content-between align-items-center mb-3"><h4 class="card-title mb-0">Products</h4><a href="{{ route('admin.products.create') }}" class="btn btn-primary">Create Product</a></div>
    <div class="table-responsive"><table class="table text-nowrap mb-0 align-middle">
        <thead class="text-dark fs-4"><tr><th>Image</th><th>Name</th><th>Category</th><th>Status</th><th class="text-end">Actions</th></tr></thead>
        <tbody>
        @forelse($products as $product)
            <tr>
                <td><img src="{{ $product->image ? public_storage_url($product->image) : asset('img/service-1.jpg') }}" alt="{{ $product->localized_name }}" class="rounded border" style="width:60px;height:60px;object-fit:cover;"></td>
                <td>{{ $product->localized_name }}<div class="small text-muted">AR: {{ $product->name_ar ?: '-' }} | EN: {{ $product->name_en ?: '-' }}</div></td>
                <td>{{ $product->category?->localized_name ?? '-' }}</td>
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
