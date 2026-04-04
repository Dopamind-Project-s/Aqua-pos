@extends('layouts.admin')

@section('content')
@include('admin.partials.flash-messages')

<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="card-title mb-0">Clients</h4>
            <a class="btn btn-primary" href="{{ route('admin.clients.create') }}">Create Client</a>
        </div>

        <div class="table-responsive">
            <table class="table text-nowrap mb-0 align-middle">
                <thead class="text-dark fs-4">
                    <tr>
                        <th>Logo</th>
                        <th>Name</th>
                        <th>Website</th>
                        <th>Category</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($clients as $client)
                    <tr>
                        <td>
                            @if($client->logo)
                                <img src="{{ Storage::url($client->logo) }}" alt="{{ $client->localized_name }}" width="60" height="44" class="rounded border bg-white object-fit-contain">
                            @endif
                        </td>
                        <td>
                            {{ $client->localized_name }}
                            <div class="small text-muted">AR: {{ $client->name_ar ?: '-' }} | EN: {{ $client->name_en ?: '-' }}</div>
                        </td>
                        <td>
                            @if($client->website_url)
                                <a href="{{ $client->website_url }}" target="_blank" rel="noopener">{{ $client->website_url }}</a>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>{{ $client->category?->localized_name ?? '-' }}</td>
                        <td>
                            <div class="form-check form-switch">
                                <input class="form-check-input js-client-status" type="checkbox" data-id="{{ $client->id }}" {{ $client->is_active ? 'checked' : '' }}>
                                <label class="form-check-label">{{ $client->is_active ? 'Active' : 'Inactive' }}</label>
                            </div>
                        </td>
                        <td class="text-end">
                            <a href="{{ route('admin.clients.edit', $client) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form method="POST" action="{{ route('admin.clients.destroy', $client) }}" class="d-inline" onsubmit="return confirm('Delete this client?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center">No clients found.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">{{ $clients->links() }}</div>
    </div>
</div>
@endsection

@push('scripts')
<script>
const token = '{{ csrf_token() }}';
document.querySelectorAll('.js-client-status').forEach((el) => {
  el.addEventListener('change', function () {
    fetch(`/admin/clients/${this.dataset.id}/toggle-status`, {
      method: 'POST',
      headers: {'X-CSRF-TOKEN': token, 'Accept': 'application/json'}
    }).then(() => {
      this.nextElementSibling.textContent = this.checked ? 'Active' : 'Inactive';
    });
  });
});
</script>
@endpush
