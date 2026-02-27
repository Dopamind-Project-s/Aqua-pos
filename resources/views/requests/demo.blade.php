@extends('layouts.app')

@push('styles')
<style>
    .demo-page {
        background: radial-gradient(circle at top right, #eff5ff 0%, #f8fbff 48%, #ffffff 100%);
    }

    .demo-hero {
        background: linear-gradient(125deg, #0d2851 0%, #1260bb 58%, #1f7de0 100%);
        color: #fff;
        position: relative;
        overflow: hidden;
    }

    .demo-hero::after {
        content: "";
        position: absolute;
        width: 420px;
        height: 420px;
        border-radius: 50%;
        top: -180px;
        right: -120px;
        background: rgba(255, 255, 255, .14);
    }

    .demo-hero .container { position: relative; z-index: 2; }

    .demo-hero-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        border-radius: 999px;
        padding: 8px 14px;
        background: rgba(255,255,255,.14);
        border: 1px solid rgba(255,255,255,.28);
        font-size: 12px;
        font-weight: 700;
        letter-spacing: .04em;
        text-transform: uppercase;
    }

    .demo-checklist {
        background: rgba(255,255,255,.95);
        color: #0d2d5d;
        border-radius: 18px;
        border: 1px solid rgba(218, 230, 247, .9);
        box-shadow: 0 14px 28px rgba(6, 27, 61, .2);
        padding: 18px;
    }

    .demo-checklist li { margin-bottom: 10px; }
    .demo-checklist li:last-child { margin-bottom: 0; }

    .demo-layout-card {
        border: 1px solid #dfe8f5;
        border-radius: 20px;
        background: #fff;
        box-shadow: 0 14px 30px rgba(14, 35, 74, .08);
    }

    .demo-input-group .form-label {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        font-weight: 600;
        color: #1d3556;
        font-size: 14px;
    }

    .demo-input,
    .demo-textarea {
        border-radius: 12px;
        border: 1px solid #d5e0f0;
        min-height: 48px;
    }

    .demo-textarea { min-height: 130px; }

    .demo-input:focus,
    .demo-textarea:focus {
        border-color: #2f7fe1;
        box-shadow: 0 0 0 0.18rem rgba(47, 127, 225, .14);
    }

    .demo-submit {
        border-radius: 12px;
        min-height: 52px;
        font-weight: 700;
        letter-spacing: .01em;
    }

    .demo-feature-box {
        border: 1px solid #e1e9f7;
        border-radius: 16px;
        background: #fff;
        box-shadow: 0 8px 18px rgba(14, 35, 74, .06);
        padding: 15px;
    }

    .demo-feature-icon {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        background: linear-gradient(135deg, #eaf3ff, #d9eaff);
        color: #145eb6;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        font-size: 18px;
    }

    body.dark-mode .demo-page { background: linear-gradient(180deg, #0f1726 0%, #0b1420 100%); }
    body.dark-mode .demo-layout-card,
    body.dark-mode .demo-feature-box { background: #121c2c; border-color: #24354f; box-shadow: 0 12px 26px rgba(0,0,0,.34); }
    body.dark-mode .demo-input,
    body.dark-mode .demo-textarea { background: #101a2a; border-color: #2a3f5d; color: #e7edf9; }
    body.dark-mode .demo-input-group .form-label,
    body.dark-mode .demo-layout-card h3,
    body.dark-mode .demo-layout-card p,
    body.dark-mode .demo-feature-box .fw-bold,
    body.dark-mode .demo-feature-box small { color: #dce8fb !important; }
    body.dark-mode .demo-checklist { background: #f4f8ff; }

    @media (max-width: 576px) {
        .demo-hero { text-align: center; }
        .demo-hero-badge { justify-content: center; }
    }
</style>
@endpush

@section('content')
<div class="demo-page">
<section class="demo-hero py-5">
    <div class="container py-4">
        <div class="row align-items-center g-4">
            <div class="col-lg-7">
                <span class="demo-hero-badge mb-3"><i class="fas fa-magic"></i> Aqua POS Demo</span>
                <h1 class="display-5 fw-bold mb-3">Book a Personalized POS Demo</h1>
                <p class="lead mb-0">Discover how Aqua POS transforms operations with faster billing, smart inventory, and branch-level control in one connected platform.</p>
            </div>
            <div class="col-lg-5">
                <div class="demo-checklist">
                    <div class="fw-bold mb-2"><i class="fas fa-check-circle me-2 text-success"></i>What you’ll get in the demo</div>
                    <ul class="mb-0 ps-3">
                        <li><i class="fas fa-circle-check text-primary me-2"></i>Live walkthrough of POS, inventory, and reports</li>
                        <li><i class="fas fa-circle-check text-primary me-2"></i>Branch setup, roles, and permissions flow</li>
                        <li><i class="fas fa-circle-check text-primary me-2"></i>Implementation timeline and pricing options</li>
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
                <div class="demo-layout-card p-4 p-lg-5">
                    <h3 class="mb-2"><i class="fas fa-laptop-code text-primary me-2"></i>Request Product Demo</h3>
                    <p class="text-muted mb-4">Share your business details and a product specialist will contact you shortly.</p>

                    <form method="POST" action="{{ route('requests.store') }}" class="row g-3">@csrf
                        <input type="hidden" name="type" value="demo_request">
                        <input type="hidden" name="source_page" value="/request-product-demo">

                        <div class="col-md-6 demo-input-group">
                            <label class="form-label"><i class="far fa-user"></i>Full Name</label>
                            <input class="form-control demo-input" name="full_name" required>
                        </div>

                        <div class="col-md-6 demo-input-group">
                            <label class="form-label"><i class="far fa-envelope"></i>Email</label>
                            <input type="email" class="form-control demo-input" name="email">
                        </div>

                        <div class="col-md-6 demo-input-group">
                            <label class="form-label"><i class="fas fa-phone"></i>Phone</label>
                            <input class="form-control demo-input" name="phone">
                        </div>

                        <div class="col-md-6 demo-input-group">
                            <label class="form-label"><i class="far fa-building"></i>Company</label>
                            <input class="form-control demo-input" name="company">
                        </div>

                        <div class="col-md-6 demo-input-group">
                            <label class="form-label"><i class="fas fa-globe"></i>Country</label>
                            <input class="form-control demo-input" name="country">
                        </div>

                        <div class="col-md-6 demo-input-group">
                            <label class="form-label"><i class="fas fa-code-branch"></i>Branches</label>
                            <input type="number" min="1" class="form-control demo-input" name="branch_count">
                        </div>

                        <div class="col-md-6 demo-input-group">
                            <label class="form-label"><i class="fas fa-box-open"></i>Product Interest</label>
                            <input class="form-control demo-input" name="product_interest">
                        </div>

                        <div class="col-md-6 demo-input-group">
                            <label class="form-label"><i class="far fa-clock"></i>Preferred Contact Time</label>
                            <input class="form-control demo-input" name="preferred_contact_time" placeholder="e.g. 10:00 AM">
                        </div>

                        <div class="col-12 demo-input-group">
                            <label class="form-label"><i class="far fa-comment-dots"></i>Notes</label>
                            <textarea class="form-control demo-textarea" name="message" rows="5"></textarea>
                        </div>

                        <div class="col-12 d-grid">
                            <button class="btn btn-primary demo-submit"><i class="fas fa-paper-plane me-2"></i>Submit Demo Request</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="d-flex flex-column gap-3">
                    <div class="demo-feature-box">
                        <div class="d-flex gap-3 align-items-start">
                            <span class="demo-feature-icon"><i class="fas fa-store"></i></span>
                            <div><div class="fw-bold">Built for multi-branch businesses</div><small class="text-muted">Operate all branches from a unified dashboard with full cashier control.</small></div>
                        </div>
                    </div>

                    <div class="demo-feature-box">
                        <div class="d-flex gap-3 align-items-start">
                            <span class="demo-feature-icon"><i class="fas fa-boxes-stacked"></i></span>
                            <div><div class="fw-bold">Advanced inventory management</div><small class="text-muted">Monitor stock in real time and receive proactive low-stock alerts.</small></div>
                        </div>
                    </div>

                    <div class="demo-feature-box">
                        <div class="d-flex gap-3 align-items-start">
                            <span class="demo-feature-icon"><i class="fas fa-headset"></i></span>
                            <div><div class="fw-bold">Local onboarding & support</div><small class="text-muted">Dedicated assistance for setup, staff training, and smooth go-live.</small></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
</div>
@endsection
