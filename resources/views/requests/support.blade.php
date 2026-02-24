@extends('layouts.app')

@push('styles')
<style>
    .support-hero { background: linear-gradient(135deg, #0b1d3a, #133f79); color: #fff; }
    .support-card { border: 0; border-radius: 16px; box-shadow: 0 12px 28px rgba(8, 27, 55, .14); }
    .support-tile { background: #f8faff; border: 1px solid #e8edf6; border-radius: 14px; padding: 18px; }
    .support-icon { width: 44px; height: 44px; border-radius: 50%; background: #e6f0ff; color: #1553a8; display: inline-flex; align-items: center; justify-content: center; }
</style>
@endpush

@section('content')
<section class="support-hero py-5">
    <div class="container py-4 text-center">
        <span class="badge bg-light text-dark px-3 py-2 mb-3">Support Center</span>
        <h1 class="display-5 fw-bold mb-3">How can we help you today?</h1>
        <p class="lead mb-0">Raise a technical or operational issue and our support team will respond quickly.</p>
    </div>
</section>

<section class="py-5">
    <div class="container">
        @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
        <div class="row g-4 mb-4">
            <div class="col-md-4"><div class="support-tile h-100"><div class="support-icon mb-2"><i class="fas fa-life-ring"></i></div><h6>Technical Support</h6><p class="mb-0 text-muted">POS devices, printers, and app issues.</p></div></div>
            <div class="col-md-4"><div class="support-tile h-100"><div class="support-icon mb-2"><i class="fas fa-tools"></i></div><h6>Setup Assistance</h6><p class="mb-0 text-muted">Configuration and integration support.</p></div></div>
            <div class="col-md-4"><div class="support-tile h-100"><div class="support-icon mb-2"><i class="fas fa-user-check"></i></div><h6>Account Help</h6><p class="mb-0 text-muted">Users, permissions, and access issues.</p></div></div>
        </div>

        <div class="card support-card p-4 p-lg-5">
            <h3 class="mb-2">Submit Support Request</h3>
            <p class="text-muted mb-4">Please provide as much detail as possible so we can resolve your issue faster.</p>
            <form method="POST" action="{{ route('requests.store') }}" class="row g-3">@csrf
                <input type="hidden" name="type" value="support_request">
                <input type="hidden" name="source_page" value="/support">
                <div class="col-md-6"><label class="form-label">Full Name</label><input class="form-control" name="full_name" required></div>
                <div class="col-md-6"><label class="form-label">Email</label><input type="email" class="form-control" name="email"></div>
                <div class="col-md-6"><label class="form-label">Phone</label><input class="form-control" name="phone"></div>
                <div class="col-md-6"><label class="form-label">Company</label><input class="form-control" name="company"></div>
                <div class="col-12"><label class="form-label">Subject</label><input class="form-control" name="subject" placeholder="Issue title"></div>
                <div class="col-12"><label class="form-label">Support Details</label><textarea class="form-control" name="message" rows="6"></textarea></div>
                <div class="col-12 d-grid d-md-flex justify-content-md-end"><button class="btn btn-primary px-5">Submit Support Request</button></div>
            </form>
        </div>
    </div>
</section>
@endsection
