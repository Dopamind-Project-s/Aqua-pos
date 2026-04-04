@extends('layouts.admin')

@section('content')

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
                <button type="submit" class="btn btn-primary w-100">Filter</button>
                <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-primary w-100">Reset</a>
            </div>
        </form>
    </div>
</div>

<form action="{{ route('admin.categories.bulk-action') }}" method="POST" id="bulk-form">
    @csrf
    <input type="hidden" name="confirm_bulk" value="1">

    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="card-title mb-0">Categories</h4>
                <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">Create Category</a>
            </div>

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
                <table class="table text-nowrap mb-0 align-middle">
                    <thead class="text-dark fs-4">
                    <tr>
                        <th><input type="checkbox" id="check-all"></th>
                        <th>Name</th>
                        <th>Image</th>
                        <th>Slug</th>
                        <th>Status</th>
                        <th>Sort</th>
                        <th>Products</th>
                        <th>Created At</th>
                        <th class="text-end">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($categories as $category)
                        <tr class="{{ $category->trashed() ? 'table-danger' : '' }}">
                            <td><input type="checkbox" name="category_ids[]" value="{{ $category->id }}" class="category-checkbox"></td>
                            <td>{{ $category->localized_name }}<div class='small text-muted'>AR: {{ $category->name_ar ?: '-' }} | EN: {{ $category->name_en ?: '-' }}</div></td>
                            <td><img src="{{ $category->image_url }}" alt="{{ $category->localized_name }}" width="70" height="48" class="rounded border object-fit-cover"></td>
                            <td>{{ $category->slug }}</td>
                            <td>
                                <span class="badge {{ $category->is_active ? 'bg-success' : 'bg-secondary' }}">{{ $category->is_active ? 'Active' : 'Inactive' }}</span>
                                @if($category->trashed())<span class="badge bg-danger">Deleted</span>@endif
                            </td>
                            <td>{{ $category->sort_order }}</td>
                            <td>{{ $category->products_count }}</td>
                            <td>{{ $category->created_at?->format('Y-m-d H:i') }}</td>
                            <td class="text-end">
                                <a href="{{ route('admin.categories.show', $category->id) }}" class="btn btn-sm btn-info">View</a>
                                @unless($category->trashed())
                                    <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('admin.categories.toggle-status', $category->id) }}" method="POST" class="d-inline">@csrf<button type="submit" class="btn btn-sm btn-secondary">{{ $category->is_active ? 'Deactivate' : 'Activate' }}</button></form>
                                    <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="d-inline" onsubmit="return confirmCategoryDelete({{ $category->products_count }});">@csrf @method('DELETE')<input type="hidden" name="confirm_delete" value="1"><button type="submit" class="btn btn-sm btn-danger">Soft Delete</button></form>
                                @else
                                    <form action="{{ route('admin.categories.force-delete', $category->id) }}" method="POST" class="d-inline" onsubmit="return confirmCategoryForceDelete({{ $category->products_count }});">@csrf @method('DELETE')<input type="hidden" name="confirm_delete" value="1"><button type="submit" class="btn btn-sm btn-dark">Force Delete</button></form>
                                @endunless
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="9" class="text-center">No categories found.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            {{ $categories->links() }}
        </div>
    </div>
</form>

@endsection

@push('scripts')
<script>
// same JS
const checkAll=document.getElementById('check-all');
if(checkAll){checkAll.addEventListener('change',e=>document.querySelectorAll('.category-checkbox').forEach(c=>c.checked=e.target.checked));}
function confirmCategoryDelete(c){return confirm(c>0?`This category has ${c} related product(s). They will be soft deleted too. Confirm?`:'Confirm soft deleting this category?');}
function confirmCategoryForceDelete(c){return confirm(c>0?`This category has ${c} related product(s). They will be permanently deleted too. Confirm?`:'Confirm permanently deleting this category?');}
function confirmBulkAction(){const a=document.querySelector('select[name="action"]').value;const s=document.querySelectorAll('.category-checkbox:checked').length;if(!a){alert('Please choose a bulk action.');return false;}if(!s){alert('Please select at least one category.');return false;}return confirm(`Apply "${a}" to ${s} selected categor${s>1?'ies':'y'}?`);}
</script>
@endpush
