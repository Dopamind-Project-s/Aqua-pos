@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        @include('admin.partials.sidebar')

        <main class="col-md-9 col-lg-10 p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="mb-0">Categories</h2>
                <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">Create Category</a>
            </div>

            @include('admin.partials.flash-messages')

            <div class="card mb-3">
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.categories.index') }}" class="row g-2">
                        <div class="col-md-5">
                            <input type="text" name="search" value="{{ $search }}" class="form-control" placeholder="Search by category name">
                        </div>
                        <div class="col-md-4">
                            <select name="status" class="form-select">
                                <option value="all" @selected($status==='all')>All</option>
                                <option value="active" @selected($status==='active')>Active</option>
                                <option value="inactive" @selected($status==='inactive')>Inactive</option>
                                <option value="deleted" @selected($status==='deleted')>Deleted</option>
                            </select>
                        </div>
                        <div class="col-md-3 d-flex gap-2">
                            <button type="submit" class="btn btn-outline-primary w-100">Filter</button>
                            <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary w-100">Reset</a>
                        </div>
                    </form>
                </div>
            </div>

            <form action="{{ route('admin.categories.bulk-action') }}" method="POST" id="bulk-form">
                @csrf
                <input type="hidden" name="confirm_bulk" value="1">

                <div class="card">
                    <div class="card-body">
                        <div class="d-flex flex-wrap gap-2 mb-3">
                            <select name="action" class="form-select" style="max-width: 260px" required>
                                <option value="">Bulk actions...</option>
                                <option value="activate">Bulk Activate</option>
                                <option value="deactivate">Bulk Deactivate</option>
                                <option value="soft_delete">Bulk Soft Delete</option>
                            </select>
                            <button type="submit" class="btn btn-dark" onclick="return confirmBulkAction()">Apply</button>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-striped align-middle">
                                <thead>
                                <tr>
                                    <th><input type="checkbox" id="check-all"></th>
                                    <th>Name</th>
                                    <th>Slug</th>
                                    <th>Status</th>
                                    <th>Products</th>
                                    <th>Created At</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($categories as $category)
                                    <tr class="{{ $category->trashed() ? 'table-danger' : '' }}">
                                        <td>
                                            <input type="checkbox" name="category_ids[]" value="{{ $category->id }}" class="category-checkbox">
                                        </td>
                                        <td>{{ $category->name }}</td>
                                        <td>{{ $category->slug }}</td>
                                        <td>
                                            <span class="badge {{ $category->is_active ? 'bg-success' : 'bg-secondary' }}">
                                                {{ $category->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                            @if($category->trashed())
                                                <span class="badge bg-danger">Deleted</span>
                                            @endif
                                        </td>
                                        <td>{{ $category->products_count }}</td>
                                        <td>{{ $category->created_at?->format('Y-m-d H:i') }}</td>
                                        <td class="text-end">
                                            <a href="{{ route('admin.categories.show', $category->id) }}" class="btn btn-sm btn-info">View</a>

                                            @unless($category->trashed())
                                                <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-sm btn-warning">Edit</a>

                                                <form action="{{ route('admin.categories.toggle-status', $category->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-secondary">
                                                        {{ $category->is_active ? 'Deactivate' : 'Activate' }}
                                                    </button>
                                                </form>

                                                <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="d-inline" onsubmit="return confirmCategoryDelete({{ $category->products_count }});">
                                                    @csrf
                                                    @method('DELETE')
                                                    <input type="hidden" name="confirm_delete" value="1">
                                                    <button type="submit" class="btn btn-sm btn-danger">Soft Delete</button>
                                                </form>
                                            @else
                                                <form action="{{ route('admin.categories.force-delete', $category->id) }}" method="POST" class="d-inline" onsubmit="return confirmCategoryForceDelete({{ $category->products_count }});">
                                                    @csrf
                                                    @method('DELETE')
                                                    <input type="hidden" name="confirm_delete" value="1">
                                                    <button type="submit" class="btn btn-sm btn-dark">Force Delete</button>
                                                </form>
                                            @endunless
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">No categories found.</td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>

                        {{ $categories->links() }}
                    </div>
                </div>
            </form>
        </main>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('check-all')?.addEventListener('change', function (event) {
        document.querySelectorAll('.category-checkbox').forEach((checkbox) => {
            checkbox.checked = event.target.checked;
        });
    });

    function confirmCategoryDelete(productsCount) {
        const message = productsCount > 0
            ? `This category has ${productsCount} related product(s). They will be soft deleted too. Confirm?`
            : 'Confirm soft deleting this category?';

        return confirm(message);
    }

    function confirmCategoryForceDelete(productsCount) {
        const message = productsCount > 0
            ? `This category has ${productsCount} related product(s). They will be permanently deleted too. Confirm?`
            : 'Confirm permanently deleting this category?';

        return confirm(message);
    }

    function confirmBulkAction() {
        const action = document.querySelector('select[name="action"]').value;
        const selected = document.querySelectorAll('.category-checkbox:checked').length;

        if (!action) {
            alert('Please choose a bulk action.');
            return false;
        }

        if (selected === 0) {
            alert('Please select at least one category.');
            return false;
        }

        return confirm(`Apply "${action}" to ${selected} selected categor${selected > 1 ? 'ies' : 'y'}?`);
    }
</script>
@endpush
