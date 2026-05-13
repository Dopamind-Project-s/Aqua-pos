@extends('layouts.admin')

@section('content')
@include('admin.partials.flash-messages')
<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="card-title mb-0">Team Members</h4>
            <a href="{{ route('admin.team-members.create') }}" class="btn btn-primary">Create Team Member</a>
        </div>

        <div class="alert alert-info">Drag and drop rows to reorder team cards on the public team page.</div>

        <div class="table-responsive">
            <table class="table text-nowrap align-middle">
                <thead class="text-dark fs-4">
                    <tr><th>#</th><th>Photo</th><th>Name</th><th>Contact</th><th>Status</th><th class="text-end">Actions</th></tr>
                </thead>
                <tbody id="teamMembersSortable">
                @forelse($teamMembers as $teamMember)
                    <tr data-id="{{ $teamMember->id }}">
                        <td><i class="ti ti-grip-vertical"></i></td>
                        <td>
                            <img src="{{ $teamMember->photo_url }}" alt="{{ $teamMember->localized_name }}" class="rounded border object-fit-cover bg-white" width="70" height="70">
                        </td>
                        <td>
                            <div class="fw-semibold">{{ $teamMember->localized_name }}</div>
                            <small class="text-muted d-block">{{ $teamMember->localized_role ?: '-' }}</small>
                            <small class="text-muted">Order: {{ $teamMember->sort_order }}</small>
                        </td>
                        <td>
                            <div>{{ $teamMember->email ?: '-' }}</div>
                            @if($teamMember->linkedin_url)
                                <a href="{{ $teamMember->linkedin_url }}" target="_blank" rel="noopener">LinkedIn</a>
                            @endif
                        </td>
                        <td>
                            <div class="form-check form-switch">
                                <input class="form-check-input js-status-toggle" type="checkbox" data-id="{{ $teamMember->id }}" {{ $teamMember->is_active ? 'checked' : '' }}>
                                <label class="form-check-label">{{ $teamMember->is_active ? 'Active' : 'Inactive' }}</label>
                            </div>
                        </td>
                        <td class="text-end">
                            <a href="{{ route('admin.team-members.edit', $teamMember) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('admin.team-members.destroy', $teamMember) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this team member?');">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger" type="submit">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center py-4">No team members found.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">{{ $teamMembers->links() }}</div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.3/Sortable.min.js"></script>
<script>
    const token = '{{ csrf_token() }}';
    const sortableEl = document.getElementById('teamMembersSortable');

    if (sortableEl) {
        new Sortable(sortableEl, {
            animation: 150,
            onEnd: function () {
                const orderedIds = [...sortableEl.querySelectorAll('tr[data-id]')].map((row) => Number(row.dataset.id));

                fetch('{{ route('admin.team-members.reorder') }}', {
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
            fetch(`/admin/team-members/${this.dataset.id}/toggle-status`, {
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
