@extends('layouts.admin')

@section('content')
@include('admin.partials.flash-messages')
<div class="card">
    <div class="card-body">
        <h4 class="card-title mb-3">Service Requests</h4>

        <form method="GET" action="{{ route('admin.requests.index') }}" class="row g-2 mb-4">
            <input type="hidden" name="tab" value="{{ $tab }}">

            <div class="col-md-4">
                <input
                    type="text"
                    name="search"
                    value="{{ $filters['search'] ?? '' }}"
                    class="form-control"
                    placeholder="Search by name, email, phone, company, subject"
                >
            </div>

            <div class="col-md-2">
                <select name="status" class="form-select">
                    <option value="">All Statuses</option>
                    @foreach($statusOptions as $value => $label)
                        <option value="{{ $value }}" {{ ($filters['status'] ?? '') === $value ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-2">
                <input type="date" name="date_from" value="{{ $filters['date_from'] ?? '' }}" class="form-control">
            </div>

            <div class="col-md-2">
                <input type="date" name="date_to" value="{{ $filters['date_to'] ?? '' }}" class="form-control">
            </div>

            <div class="col-md-2 d-flex gap-2">
                <button type="submit" class="btn btn-primary w-100">Filter</button>
                <a href="{{ route('admin.requests.index', ['tab' => $tab]) }}" class="btn btn-outline-secondary w-100">Reset</a>
            </div>
        </form>

        <ul class="nav nav-tabs mb-3" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link {{ $tab === 'demo_request' ? 'active' : '' }}" href="{{ route('admin.requests.index', ['tab' => 'demo_request'] + request()->except(['tab', 'demo_page', 'support_page', 'contact_page'])) }}">Demo Requests</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link {{ $tab === 'support_request' ? 'active' : '' }}" href="{{ route('admin.requests.index', ['tab' => 'support_request'] + request()->except(['tab', 'demo_page', 'support_page', 'contact_page'])) }}">Support Requests</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link {{ $tab === 'contact_request' ? 'active' : '' }}" href="{{ route('admin.requests.index', ['tab' => 'contact_request'] + request()->except(['tab', 'demo_page', 'support_page', 'contact_page'])) }}">Contact Requests</a>
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
                        <td>
                            <form method="POST" action="{{ route('admin.requests.update-status', $row) }}" class="d-flex gap-2 align-items-center">
                                @csrf
                                @method('PATCH')

                                <select name="status" class="form-select form-select-sm" style="min-width: 130px;">
                                    @foreach($statusOptions as $value => $label)
                                        <option value="{{ $value }}" {{ $row->status === $value ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                                <button type="submit" class="btn btn-sm btn-outline-primary">Save</button>
                            </form>
                        </td>
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
