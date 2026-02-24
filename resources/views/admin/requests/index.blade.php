@extends('layouts.admin')

@section('content')
<div class="card">
    <div class="card-body">
        <h4 class="card-title mb-3">Service Requests</h4>

        <ul class="nav nav-tabs mb-3" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link {{ $tab === 'demo_request' ? 'active' : '' }}" href="{{ route('admin.requests.index', ['tab' => 'demo_request']) }}">Demo Requests</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link {{ $tab === 'support_request' ? 'active' : '' }}" href="{{ route('admin.requests.index', ['tab' => 'support_request']) }}">Support Requests</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link {{ $tab === 'contact_request' ? 'active' : '' }}" href="{{ route('admin.requests.index', ['tab' => 'contact_request']) }}">Contact Requests</a>
            </li>
        </ul>

        @php
            $current = $tab === 'demo_request' ? $demoRequests : ($tab === 'support_request' ? $supportRequests : $contactRequests);
        @endphp

        <div class="table-responsive">
            <table class="table text-nowrap mb-0 align-middle">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Company</th>
                    <th>Subject</th>
                    <th>Status</th>
                    <th>Date</th>
                </tr>
                </thead>
                <tbody>
                @forelse($current as $row)
                    <tr>
                        <td>{{ $row->id }}</td>
                        <td>{{ $row->full_name }}</td>
                        <td>{{ $row->email ?? '-' }}</td>
                        <td>{{ $row->phone ?? '-' }}</td>
                        <td>{{ $row->company ?? '-' }}</td>
                        <td>{{ $row->subject ?? '-' }}</td>
                        <td><span class="badge bg-secondary">{{ $row->status }}</span></td>
                        <td>{{ $row->created_at?->format('Y-m-d H:i') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="8" class="text-center">No requests found.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $current->links() }}
        </div>
    </div>
</div>
@endsection
