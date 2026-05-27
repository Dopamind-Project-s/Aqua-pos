@extends('layouts.app')

@push('styles')
<style>
    .demo-page {
        background: radial-gradient(circle at top right, #eff5ff 0%, #f8fbff 48%, #ffffff 100%);
        padding-top: clamp(5.3rem, 7vw, 6.8rem);
    }

    .demo-hero {
        background: linear-gradient(125deg, #0d2851 0%, #1260bb 58%, #1f7de0 100%);
        color: #fff;
        position: relative;
        overflow: hidden;
        border-radius: 0 0 22px 22px;
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

    .demo-country-chip {
        border: 1px solid #d5e0f0;
        border-radius: 12px;
        min-height: 48px;
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 12px;
        color: #1d3556;
        background: #f6f9ff;
        font-weight: 600;
    }

    .demo-country-flag {
        font-size: 1.2rem;
        line-height: 1;
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
    body.dark-mode .demo-country-chip { background: #101a2a; border-color: #2a3f5d; color: #e7edf9; }
    body.dark-mode .demo-input-group .form-label,
    body.dark-mode .demo-layout-card h3,
    body.dark-mode .demo-layout-card p,
    body.dark-mode .demo-feature-box .fw-bold,
    body.dark-mode .demo-feature-box small,
    body.dark-mode .demo-checklist,
    body.dark-mode .demo-checklist li { color: #dce8fb !important; }
    body.dark-mode .demo-checklist {
        background: rgba(18, 28, 44, .9);
        border-color: #2a3f5d;
    }
    body.dark-mode .demo-feature-icon {
        background: linear-gradient(135deg, #21324c, #1b2940);
        color: #9bc2ff;
    }

    @media (max-width: 576px) {
        .demo-page {
            padding-top: 4.7rem;
        }

        .demo-hero { text-align: center; border-radius: 0 0 18px 18px; }
        .demo-hero-badge { justify-content: center; }
    }
</style>
@endpush

@section('content')
<div class="demo-page">
@include('partials.page-hero', [
    'offset' => false,
    'class' => 'demo-hero',
    'icon' => 'fas fa-magic',
    'badge' => 'Aqua POS Demo',
    'badgeI18n' => 'demo.badge',
    'title' => 'Book a Personalized POS Demo',
    'titleI18n' => 'demo.title',
    'subtitle' => 'Discover how Aqua POS transforms operations with faster billing, smart inventory, and branch-level control in one connected platform.',
    'subtitleI18n' => 'demo.subtitle',
])

<section class="py-5">
    <div class="container">
        @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
        <div class="row g-4">
            <div class="col-lg-7">
                <div class="demo-layout-card p-4 p-lg-5">
                    <h3 class="mb-2"><i class="fas fa-laptop-code text-primary me-2"></i><span data-i18n="demo.formTitle">Request Product Demo</span></h3>
                    <p class="text-muted mb-4" data-i18n="demo.formSubtitle">Share your business details and a product specialist will contact you shortly.</p>

                    <form method="POST" action="{{ route('requests.store') }}" class="row g-3">@csrf
                        <input type="hidden" name="type" value="demo_request">
                        <input type="hidden" name="source_page" value="/request-product-demo">

                        <div class="col-md-6 demo-input-group">
                            <label class="form-label"><i class="far fa-user"></i><span data-i18n="demo.fullName">Full Name</span></label>
                            <input class="form-control demo-input" name="full_name" required>
                        </div>

                        <div class="col-md-6 demo-input-group">
                            <label class="form-label"><i class="far fa-envelope"></i><span data-i18n="demo.email">Email</span></label>
                            <input type="email" class="form-control demo-input" name="email">
                        </div>

                        <div class="col-md-6 demo-input-group">
                            <label class="form-label"><i class="fas fa-phone"></i><span data-i18n="demo.phone">Phone</span></label>
                            <input class="form-control demo-input" name="phone">
                        </div>

                        <div class="col-md-6 demo-input-group">
                            <label class="form-label"><i class="far fa-building"></i><span data-i18n="demo.company">Company</span></label>
                            <input class="form-control demo-input" name="company">
                        </div>

                        <div class="col-md-6 demo-input-group">
                            <label class="form-label"><i class="fas fa-globe"></i><span data-i18n="demo.country">Country</span></label>
                            <input type="hidden" name="country" id="demoCountryInput">
                            <div class="demo-country-chip" id="demoCountryChip" aria-live="polite">
                                <span class="demo-country-flag" id="demoCountryFlag">🌐</span>
                                <span id="demoCountryText" data-i18n="demo.countryDetecting">Detecting your country...</span>
                            </div>
                        </div>

                        <div class="col-md-6 demo-input-group">
                            <label class="form-label"><i class="fas fa-code-branch"></i><span data-i18n="demo.branches">Branches</span></label>
                            <input type="number" min="1" class="form-control demo-input" name="branch_count">
                        </div>

                        <div class="col-md-6 demo-input-group">
                            <label class="form-label"><i class="fas fa-box-open"></i><span data-i18n="demo.productInterest">Product Interest</span></label>
                            <input class="form-control demo-input" name="product_interest">
                        </div>

                        <div class="col-md-6 demo-input-group">
                            <label class="form-label"><i class="far fa-clock"></i><span data-i18n="demo.preferredContactTime">Preferred Contact Time</span></label>
                            <input class="form-control demo-input" name="preferred_contact_time" data-i18n-placeholder="demo.preferredContactPlaceholder" placeholder="e.g. 10:00 AM">
                        </div>

                        <div class="col-12 demo-input-group">
                            <label class="form-label"><i class="far fa-comment-dots"></i><span data-i18n="demo.notes">Notes</span></label>
                            <textarea class="form-control demo-textarea" name="message" rows="5"></textarea>
                        </div>

                        <div class="col-12 d-grid">
                            <button class="btn btn-primary demo-submit"><i class="fas fa-paper-plane me-2"></i><span data-i18n="demo.submit">Submit Demo Request</span></button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="d-flex flex-column gap-3">
                    <div class="demo-feature-box">
                        <div class="d-flex gap-3 align-items-start">
                            <span class="demo-feature-icon"><i class="fas fa-store"></i></span>
                            <div><div class="fw-bold" data-i18n="demo.feature1Title">Built for multi-branch businesses</div><small class="text-muted" data-i18n="demo.feature1Desc">Operate all branches from a unified dashboard with full cashier control.</small></div>
                        </div>
                    </div>

                    <div class="demo-feature-box">
                        <div class="d-flex gap-3 align-items-start">
                            <span class="demo-feature-icon"><i class="fas fa-boxes-stacked"></i></span>
                            <div><div class="fw-bold" data-i18n="demo.feature2Title">Advanced inventory management</div><small class="text-muted" data-i18n="demo.feature2Desc">Monitor stock in real time and receive proactive low-stock alerts.</small></div>
                        </div>
                    </div>

                    <div class="demo-feature-box">
                        <div class="d-flex gap-3 align-items-start">
                            <span class="demo-feature-icon"><i class="fas fa-headset"></i></span>
                            <div><div class="fw-bold" data-i18n="demo.feature3Title">Local onboarding & support</div><small class="text-muted" data-i18n="demo.feature3Desc">Dedicated assistance for setup, staff training, and smooth go-live.</small></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const countryInput = document.getElementById('demoCountryInput');
    const countryText = document.getElementById('demoCountryText');
    const countryFlag = document.getElementById('demoCountryFlag');

    if (!countryInput || !countryText || !countryFlag) return;

    const toFlag = (code) => {
        if (!code || code.length !== 2) return '🌐';
        const chars = code.toUpperCase().split('');
        return String.fromCodePoint(...chars.map(c => 127397 + c.charCodeAt()));
    };

    const setCountry = (name, code) => {
        countryInput.value = name || '';
        countryText.textContent = name || countryText.textContent;
        countryFlag.textContent = toFlag(code);
    };

    fetch('https://ipapi.co/json/')
        .then((response) => response.ok ? response.json() : null)
        .then((data) => {
            if (!data) return;
            setCountry(data.country_name, data.country_code);
        })
        .catch(() => {
            const lang = document.documentElement.getAttribute('lang') || 'en';
            countryText.textContent = lang === 'ar' ? 'تعذر التحديد التلقائي' : 'Auto-detection unavailable';
            countryFlag.textContent = '🌐';
        });
});
</script>
@endpush
