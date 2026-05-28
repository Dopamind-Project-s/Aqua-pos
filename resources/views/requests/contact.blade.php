@extends('layouts.app')

@push('styles')
<style>
    .contact-page {
        background: radial-gradient(circle at left top, #eef6ff 0%, #f5f9ff 45%, #ffffff 100%);
        padding-top: clamp(5.2rem, 7vw, 6.6rem);
    }

    .contact-hero {
        background: linear-gradient(135deg, #0d2851 0%, #1260bb 58%, #1f7de0 100%);
        color: #fff;
        border-radius: 0 0 24px 24px;
        position: relative;
        overflow: hidden;
    }

    .contact-hero::before {
        content: "";
        position: absolute;
        width: 360px;
        height: 360px;
        border-radius: 50%;
        top: -170px;
        left: -120px;
        background: rgba(255, 255, 255, .14);
    }

    .contact-hero .container { position: relative; z-index: 2; }

    .contact-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 14px;
        border-radius: 999px;
        border: 1px solid rgba(255,255,255,.3);
        background: rgba(255,255,255,.16);
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .04em;
    }

    .contact-card {
        border: 1px solid #dce9fb;
        border-radius: 20px;
        background: #fff;
        box-shadow: 0 12px 26px rgba(80, 38, 8, .08);
    }

    .contact-info-box {
        border: 1px solid #e3edf9;
        border-radius: 16px;
        background: linear-gradient(180deg, #f5f9ff, #edf4ff);
        padding: 16px;
    }

    .contact-icon {
        width: 46px;
        height: 46px;
        border-radius: 12px;
        background: linear-gradient(135deg, #e0ecff, #c8defe);
        color: #1658ab;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        flex-shrink: 0;
    }

    .contact-form .form-label {
        display: inline-flex;
        gap: 7px;
        align-items: center;
        color: #1d3556;
        font-weight: 600;
    }

    .contact-form .form-control {
        border-radius: 12px;
        border-color: #d3e2f6;
        min-height: 48px;
    }

    .contact-form textarea.form-control { min-height: 140px; }

    .contact-form .form-control:focus {
        border-color: #2f7fe1;
        box-shadow: 0 0 0 .18rem rgba(47, 127, 225, .18);
    }

    .contact-submit {
        border-radius: 12px;
        min-height: 52px;
        font-weight: 700;
        background: linear-gradient(135deg, #1b63c0, #2f7fe1);
        border: none;
    }

    .contact-submit:hover { filter: brightness(1.02); }

    body.dark-mode .contact-page { background: linear-gradient(180deg, #0f1726 0%, #0b1420 100%); }
    body.dark-mode .contact-card,
    body.dark-mode .contact-info-box {
        background: #121c2c;
        border-color: #24354f;
        box-shadow: 0 12px 26px rgba(0,0,0,.35);
    }

    body.dark-mode .contact-form .form-control {
        background: #101a2a;
        border-color: #24354f;
        color: #e7edf9;
    }

    body.dark-mode .contact-form .form-label,
    body.dark-mode .contact-card h3,
    body.dark-mode .contact-card h6,
    body.dark-mode .contact-card p,
    body.dark-mode .contact-card small,
    body.dark-mode .contact-card .text-muted {
        color: #dce8fb !important;
    }

    body.dark-mode .contact-icon {
        background: linear-gradient(135deg, #21324c, #1b2940);
        color: #9bc2ff;
    }

    @media (max-width: 576px) {
        .contact-page { padding-top: 4.7rem; }
        .contact-hero { text-align: center; border-radius: 0 0 18px 18px; }
        .contact-badge { justify-content: center; }
    }
</style>
@endpush

@section('content')
<div class="contact-page">
@include('partials.page-hero', [
    'offset' => false,
    'class' => 'contact-hero',
    'icon' => 'fas fa-envelope-open-text',
    'badge' => 'Contact Desk',
    'badgeI18n' => 'contact.badge',
    'title' => 'Let’s talk about your business needs',
    'titleI18n' => 'contact.title',
    'subtitle' => 'Send your inquiry and our team will reach out with the best plan for your operations.',
    'subtitleI18n' => 'contact.subtitle',
])

<section class="py-5">
    <div class="container">
        @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
        <div class="row g-4">
            <div class="col-lg-4">
                <div class="d-flex flex-column gap-3">
                    <div class="contact-info-box">
                        <div class="d-flex gap-3 align-items-start">
                            <span class="contact-icon"><i class="fas fa-headset"></i></span>
                            <div>
                                <h6 class="mb-1" data-i18n="contact.info1Title">Fast Response</h6>
                                <small class="text-muted" data-i18n="contact.info1Desc">We review contact requests quickly and assign the right specialist.</small>
                            </div>
                        </div>
                    </div>
                    <div class="contact-info-box">
                        <div class="d-flex gap-3 align-items-start">
                            <span class="contact-icon"><i class="fas fa-map-marked-alt"></i></span>
                            <div>
                                <h6 class="mb-1" data-i18n="contact.info2Title">Local Team</h6>
                                <small class="text-muted" data-i18n="contact.info2Desc">Regional team support with practical implementation guidance.</small>
                            </div>
                        </div>
                    </div>
                    <div class="contact-info-box">
                        <div class="d-flex gap-3 align-items-start">
                            <span class="contact-icon"><i class="fas fa-shield-alt"></i></span>
                            <div>
                                <h6 class="mb-1" data-i18n="contact.info3Title">Confidential Communication</h6>
                                <small class="text-muted" data-i18n="contact.info3Desc">Your details are handled securely and used only for follow-up.</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="contact-card p-4 p-lg-5">
                    <h3 class="mb-2"><i class="fas fa-paper-plane text-warning me-2"></i><span data-i18n="contact.formTitle">Submit Contact Request</span></h3>
                    <p class="text-muted mb-4" data-i18n="contact.formSubtitle">Share your details and message so we can contact you effectively.</p>

                    @if($selectedPartner)
                        <div class="contact-info-box mb-4">
                            <div class="d-flex gap-3 align-items-start">
                                <span class="contact-icon"><i class="fas fa-map-marker-alt"></i></span>
                                <div>
                                    <h6 class="mb-1" data-i18n="contact.selectedPartnerTitle">Selected Partner Pin</h6>
                                    <small class="text-muted">
                                        {{ $selectedPartner->localized_name }}
                                        @if($selectedPartner->localized_map_location)
                                            - {{ $selectedPartner->localized_map_location }}
                                        @endif
                                    </small>
                                </div>
                            </div>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('requests.store') }}" class="row g-3 contact-form">@csrf
                        <input type="hidden" name="type" value="contact_request">
                        <input type="hidden" name="source_page" value="/contact">
                        @if($selectedPartner)
                            <input type="hidden" name="selected_partner_id" value="{{ $selectedPartner->id }}">
                        @endif

                        <div class="col-md-6"><label class="form-label"><i class="far fa-user"></i><span data-i18n="contact.fullName">Full Name</span></label><input class="form-control" name="full_name" value="{{ old('full_name') }}" required></div>
                        <div class="col-md-6"><label class="form-label"><i class="far fa-envelope"></i><span data-i18n="contact.email">Email</span></label><input type="email" class="form-control" name="email" value="{{ old('email') }}"></div>
                        <div class="col-md-6"><label class="form-label"><i class="fas fa-phone"></i><span data-i18n="contact.phone">Phone</span></label><input class="form-control" name="phone" value="{{ old('phone') }}"></div>
                        <div class="col-md-6"><label class="form-label"><i class="far fa-building"></i><span data-i18n="contact.company">Company</span></label><input class="form-control" name="company" value="{{ old('company') }}"></div>
                        <div class="col-12"><label class="form-label"><i class="fas fa-heading"></i><span data-i18n="contact.subject">Subject</span></label><input class="form-control" name="subject" value="{{ old('subject', $selectedPartner ? 'Partner location inquiry: '.$selectedPartner->localized_name : '') }}" data-i18n-placeholder="contact.subjectPlaceholder" placeholder="Your inquiry subject"></div>
                        <div class="col-12"><label class="form-label"><i class="far fa-comment-dots"></i><span data-i18n="contact.message">Message</span></label><textarea class="form-control" name="message" rows="5">{{ old('message') }}</textarea></div>
                        <div class="col-12 d-grid d-md-flex justify-content-md-end"><button class="btn contact-submit px-5 text-white"><i class="fas fa-paper-plane me-2"></i><span data-i18n="contact.submit">Submit Contact Request</span></button></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
</div>
@endsection
