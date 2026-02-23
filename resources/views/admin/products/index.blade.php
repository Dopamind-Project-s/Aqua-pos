@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        @include('admin.partials.sidebar')
        <main class="col-md-9 col-lg-10 p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="mb-0">Products</h2>
                <a href="{{ route('admin.products.create') }}" class="btn btn-primary">Create Product</a>
            </div>
            @include('admin.partials.flash-messages')
            <div class="card"><div class="card-body table-responsive">
                <table class="table table-striped align-middle">
                    <thead><tr><th>Name</th><th>Category</th><th>Status</th><th class="text-end">Actions</th></tr></thead>
                    <tbody>
                    @forelse($products as $product)
                        <tr>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->category?->name ?? '-' }}</td>
                            <td><span class="badge {{ $product->is_active ? 'bg-success' : 'bg-secondary' }}">{{ $product->is_active ? 'Active' : 'Inactive' }}</span></td>
                            <td class="text-end">
                                <a class="btn btn-sm btn-info" href="{{ route('admin.products.show',$product->id) }}">View</a>
                                <a class="btn btn-sm btn-warning" href="{{ route('admin.products.edit',$product->id) }}">Edit</a>
                                <form action="{{ route('admin.products.destroy',$product->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Soft delete this product?');">@csrf @method('DELETE')<button class="btn btn-sm btn-danger" type="submit">Delete</button></form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-center">No products found.</td></tr>
                    @endforelse
                    </tbody>
                </table>
                {{ $products->links() }}
            </div></div>
        </main>
    </div>
</div>
@endsection
