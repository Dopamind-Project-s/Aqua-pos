@extends('layouts.admin')

@section('content')
<div class="row g-3 mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div>
                    <h4 class="mb-1">{{ $siteSetting?->site_name ?: 'AQUA POS' }} Admin Dashboard</h4>
                    <p class="text-muted mb-0">Clean overview for operations and content management.</p>
                </div>
                <a href="{{ route('home') }}" class="btn btn-outline-primary">View Website</a>
            </div>
        </div>
    </div>

    @foreach([
        ['label' => 'Categories', 'value' => $stats['categories'], 'icon' => 'ti ti-category'],
        ['label' => 'Products', 'value' => $stats['products'], 'icon' => 'ti ti-package'],
        ['label' => 'Posts', 'value' => $stats['posts'], 'icon' => 'ti ti-article'],
        ['label' => 'Partners', 'value' => $stats['partners'], 'icon' => 'ti ti-hand-stop'],
        ['label' => 'Clients', 'value' => $stats['clients'], 'icon' => 'ti ti-users-group'],
        ['label' => 'Requests', 'value' => $stats['requests'], 'icon' => 'ti ti-mail'],
    ] as $item)
        <div class="col-6 col-lg-4 col-xxl-2">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <span class="text-muted">{{ $item['label'] }}</span>
                        <i class="{{ $item['icon'] }} fs-5 text-primary"></i>
                    </div>
                    <h3 class="mb-0">{{ $item['value'] }}</h3>
                </div>
            </div>
        </div>
    @endforeach
</div>

<div class="row g-3">
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <h5 class="mb-3">Requests Snapshot</h5>
                <p class="mb-2">Open requests: <strong>{{ $stats['open_requests'] }}</strong></p>
                <p class="mb-0 text-muted">Open = New + In Progress.</p>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <h5 class="mb-3">Quick Links</h5>
                <div class="d-flex flex-wrap gap-2">
                    <a href="{{ route('admin.products.index') }}" class="btn btn-sm btn-light">Products</a>
                    <a href="{{ route('admin.clients.index') }}" class="btn btn-sm btn-light">Clients</a>
                    <a href="{{ route('admin.requests.index') }}" class="btn btn-sm btn-light">Requests</a>
                    <a href="{{ route('admin.settings.edit') }}" class="btn btn-sm btn-light">Settings</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
