@extends('layouts.admin')
@section('content')
@include('admin.partials.flash-messages')
<div class="card"><div class="card-body">
<div class="d-flex justify-content-between align-items-center mb-3"><h4 class="mb-0">Clients</h4><a class="btn btn-primary" href="{{ route('admin.clients.create') }}">Create Client</a></div>
<div class="table-responsive"><table class="table align-middle"><thead><tr><th>Logo</th><th>Name</th><th>Website</th><th>Status</th><th></th></tr></thead><tbody>
@forelse($clients as $client)
<tr>
<td>@if($client->logo)<img src="{{ Storage::url($client->logo) }}" width="60" height="44" class="rounded border bg-white object-fit-contain">@endif</td>
<td>{{ $client->name }}</td>
<td>{{ $client->website_url ?: '-' }}</td>
<td><div class="form-check form-switch"><input class="form-check-input js-client-status" type="checkbox" data-id="{{ $client->id }}" {{ $client->is_active ? 'checked' : '' }}></div></td>
<td class="text-end"><a href="{{ route('admin.clients.edit', $client) }}" class="btn btn-sm btn-warning">Edit</a>
<form method="POST" action="{{ route('admin.clients.destroy', $client) }}" class="d-inline">@csrf @method('DELETE')<button class="btn btn-sm btn-danger">Delete</button></form></td>
</tr>
@empty <tr><td colspan="5" class="text-center">No clients found.</td></tr>@endforelse
</tbody></table></div><div>{{ $clients->links() }}</div>
</div></div>
@endsection
@push('scripts')
<script>
const token = '{{ csrf_token() }}';
document.querySelectorAll('.js-client-status').forEach((el) => {
  el.addEventListener('change', function () {
    fetch(`/admin/clients/${this.dataset.id}/toggle-status`, {method: 'POST', headers: {'X-CSRF-TOKEN': token, 'Accept': 'application/json'}});
  });
});
</script>
@endpush
