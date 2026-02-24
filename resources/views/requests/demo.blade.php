@extends('layouts.app')

@push('styles')
<style>
    .demo-hero { background: linear-gradient(130deg, #0e2a56, #145fb6); color: #fff; }
    .demo-card { border: 0; border-radius: 18px; box-shadow: 0 14px 30px rgba(10, 35, 80, .16); }
    .demo-input { border-radius: 12px; min-height: 48px; }
    .demo-trust { background: #f7f9ff; border: 1px solid #e7ecf7; border-radius: 14px; padding: 14px; }
    .demo-feature-icon { width: 46px; height: 46px; border-radius: 50%; background: #e8f1ff; color: #1254a8; display: inline-flex; align-items: center; justify-content: center; }
</style>
@endpush

@section('content')
<section class="demo-hero py-5">
    <div class="container py-4">
        <div class="row align-items-center g-4">
            <div class="col-lg-7">
                <span class="badge bg-light text-dark px-3 py-2 mb-3">Aqua POS Demo</span>
                <h1 class="display-5 fw-bold mb-3">Book a Personalized POS Demo</h1>
                <p class="lead mb-0">See how Aqua POS helps restaurants and retailers manage sales, stock, and branches in real-time.</p>
            </div>
            <div class="col-lg-5">
                <div class="demo-trust text-dark bg-white">
                    <div class="fw-bold mb-2">What you’ll get in the demo</div>
                    <ul class="mb-0 ps-3">
                        <li>Live walkthrough of POS & inventory</li>
                        <li>Branch and permissions setup flow</li>
                        <li>Pricing and implementation plan</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
        <div class="row g-4">
            <div class="col-lg-7">
                <div class="card demo-card p-4 p-lg-5">
                    <h3 class="mb-3">Request Product Demo</h3>
                    <p class="text-muted mb-4">Fill in your business details and our team will contact you shortly.</p>
                    <form method="POST" action="{{ route('requests.store') }}" class="row g-3">@csrf
                        <input type="hidden" name="type" value="demo_request">
                        <input type="hidden" name="source_page" value="/request-product-demo">
                        <div class="col-md-6"><label class="form-label">Full Name</label><input class="form-control demo-input" name="full_name" required></div>
                        <div class="col-md-6"><label class="form-label">Email</label><input type="email" class="form-control demo-input" name="email"></div>
                        <div class="col-md-6"><label class="form-label">Phone</label><input class="form-control demo-input" name="phone"></div>
                        <div class="col-md-6"><label class="form-label">Company</label><input class="form-control demo-input" name="company"></div>
                        <div class="col-md-6"><label class="form-label">Country</label><input class="form-control demo-input" name="country"></div>
                        <div class="col-md-6"><label class="form-label">Branches</label><input type="number" min="1" class="form-control demo-input" name="branch_count"></div>
                        <div class="col-md-6"><label class="form-label">Product Interest</label><input class="form-control demo-input" name="product_interest"></div>
                        <div class="col-md-6"><label class="form-label">Preferred Contact Time</label><input class="form-control demo-input" name="preferred_contact_time" placeholder="e.g. 10:00 AM"></div>
                        <div class="col-12"><label class="form-label">Notes</label><textarea class="form-control" name="message" rows="5"></textarea></div>
                        <div class="col-12 d-grid"><button class="btn btn-primary btn-lg">Submit Demo Request</button></div>
                    </form>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="d-flex flex-column gap-3">
                    <div class="demo-trust">
                        <div class="d-flex gap-3">
                            <span class="demo-feature-icon"><i class="fas fa-store"></i></span>
                            <div><div class="fw-bold">Built for multi-branch businesses</div><small class="text-muted">Centralized control of all branches and cashiers.</small></div>
                        </div>
                    </div>
                    <div class="demo-trust">
                        <div class="d-flex gap-3">
                            <span class="demo-feature-icon"><i class="fas fa-boxes"></i></span>
                            <div><div class="fw-bold">Advanced inventory management</div><small class="text-muted">Track stock movement and low-stock alerts instantly.</small></div>
                        </div>
                    </div>
                    <div class="demo-trust">
                        <div class="d-flex gap-3">
                            <span class="demo-feature-icon"><i class="fas fa-headset"></i></span>
                            <div><div class="fw-bold">Local onboarding & support</div><small class="text-muted">Our team helps with setup, training, and go-live.</small></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
