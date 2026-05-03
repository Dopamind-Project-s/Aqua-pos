@extends('layouts.admin')

@section('content')
@include('admin.partials.flash-messages')
<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="card-title mb-0">Partners</h4>
            <a href="{{ route('admin.partners.create') }}" class="btn btn-primary">Create Partner</a>
        </div>

        <div class="alert alert-info">Drag and drop rows to reorder partner cards on the public page.</div>

        <div class="table-responsive">
            <table class="table text-nowrap align-middle" id="partnersTable">
                <thead class="text-dark fs-4"><tr><th>#</th><th>Logo</th><th>Name</th><th>Website</th><th>Status</th><th class="text-end">Actions</th></tr></thead>
                <tbody id="partnersSortable">
                @forelse($partners as $partner)
                    <tr data-id="{{ $partner->id }}">
                        <td><i class="ti ti-grip-vertical"></i></td>
                        <td>
                            @if($partner->logo)
                                <img src="{{ public_storage_url($partner->logo) }}" alt="{{ $partner->localized_name }}" class="rounded border object-fit-contain bg-white" width="70" height="54">
                            @endif
                        </td>
                        <td>
                            <div class="fw-semibold">{{ $partner->localized_name }}</div>
                            <small class="text-muted d-block">AR: {{ $partner->name_ar ?: '-' }} | EN: {{ $partner->name_en ?: '-' }}</small>
                            <small class="text-muted">Order: {{ $partner->sort_order }}</small>
                        </td>
                        <td>
                            @if($partner->website_url)
                                <a href="{{ $partner->website_url }}" target="_blank" rel="noopener">{{ $partner->website_url }}</a>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            <div class="form-check form-switch">
                                <input class="form-check-input js-status-toggle" type="checkbox" data-id="{{ $partner->id }}" {{ $partner->is_active ? 'checked' : '' }}>
                                <label class="form-check-label">{{ $partner->is_active ? 'Active' : 'Inactive' }}</label>
                            </div>
                        </td>
                        <td class="text-end">
                            <a href="{{ route('admin.partners.edit', $partner) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('admin.partners.destroy', $partner) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this partner?');">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger" type="submit">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center py-4">No partners found.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">{{ $partners->links() }}</div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.3/Sortable.min.js"></script>
<script>
    const token = '{{ csrf_token() }}';
    const sortableEl = document.getElementById('partnersSortable');

    if (sortableEl) {
        new Sortable(sortableEl, {
            animation: 150,
            onEnd: function () {
                const orderedIds = [...sortableEl.querySelectorAll('tr[data-id]')].map((row) => Number(row.dataset.id));

                fetch('{{ route('admin.partners.reorder') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ ordered_ids: orderedIds }),
                });
            }
        });
    }

    document.querySelectorAll('.js-status-toggle').forEach((el) => {
        el.addEventListener('change', function () {
            fetch(`/admin/partners/${this.dataset.id}/toggle-status`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json',
                },
            }).then(() => {
                this.nextElementSibling.textContent = this.checked ? 'Active' : 'Inactive';
            });
        });
    });
</script>
@endpush
