@extends('layouts.app')

@push('styles')
<style>
    .contact-page {
        background: radial-gradient(circle at left top, #fff7ef 0%, #fffaf4 45%, #ffffff 100%);
        padding-top: clamp(5.2rem, 7vw, 6.6rem);
    }

    .contact-hero {
        background: linear-gradient(135deg, #5a2b0a 0%, #b45a1d 58%, #e58d34 100%);
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
        border: 1px solid #f2dfcf;
        border-radius: 20px;
        background: #fff;
        box-shadow: 0 12px 26px rgba(80, 38, 8, .08);
    }

    .contact-info-box {
        border: 1px solid #f5e4d5;
        border-radius: 16px;
        background: linear-gradient(180deg, #fffaf4, #fff3e7);
        padding: 16px;
    }

    .contact-icon {
        width: 46px;
        height: 46px;
        border-radius: 12px;
        background: linear-gradient(135deg, #ffe7cf, #ffd8b0);
        color: #9a4f17;
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
        color: #5d3418;
        font-weight: 600;
    }

    .contact-form .form-control {
        border-radius: 12px;
        border-color: #efdcc9;
        min-height: 48px;
    }

    .contact-form textarea.form-control { min-height: 140px; }

    .contact-form .form-control:focus {
        border-color: #e18a36;
        box-shadow: 0 0 0 .18rem rgba(225, 138, 54, .18);
    }

    .contact-submit {
        border-radius: 12px;
        min-height: 52px;
        font-weight: 700;
        background: linear-gradient(135deg, #cc6d25, #e18a36);
        border: none;
    }

    .contact-submit:hover { filter: brightness(1.02); }

    body.dark-mode .contact-page { background: linear-gradient(180deg, #17120d 0%, #0e0b08 100%); }
    body.dark-mode .contact-card,
    body.dark-mode .contact-info-box {
        background: #1f1811;
        border-color: #4c3726;
        box-shadow: 0 12px 26px rgba(0,0,0,.35);
    }

    body.dark-mode .contact-form .form-control {
        background: #1a140f;
        border-color: #4c3726;
        color: #f6e7d6;
    }

    body.dark-mode .contact-form .form-label,
    body.dark-mode .contact-card h3,
    body.dark-mode .contact-card h6,
    body.dark-mode .contact-card p,
    body.dark-mode .contact-card small,
    body.dark-mode .contact-card .text-muted {
        color: #f1e2d2 !important;
    }

    body.dark-mode .contact-icon {
        background: linear-gradient(135deg, #52311a, #6d4121);
        color: #ffd9b0;
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
<section class="contact-hero py-5">
    <div class="container py-4 text-center">
        <span class="contact-badge mb-3"><i class="fas fa-envelope-open-text"></i><span data-i18n="contact.badge">Contact Desk</span></span>
        <h1 class="display-5 fw-bold mb-3" data-i18n="contact.title">Let’s talk about your business needs</h1>
        <p class="lead mb-0" data-i18n="contact.subtitle">Send your inquiry and our team will reach out with the best plan for your operations.</p>
    </div>
</section>

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

                    <form method="POST" action="{{ route('requests.store') }}" class="row g-3 contact-form">@csrf
                        <input type="hidden" name="type" value="contact_request">
                        <input type="hidden" name="source_page" value="/contact">

                        <div class="col-md-6"><label class="form-label"><i class="far fa-user"></i><span data-i18n="contact.fullName">Full Name</span></label><input class="form-control" name="full_name" required></div>
                        <div class="col-md-6"><label class="form-label"><i class="far fa-envelope"></i><span data-i18n="contact.email">Email</span></label><input type="email" class="form-control" name="email"></div>
                        <div class="col-md-6"><label class="form-label"><i class="fas fa-phone"></i><span data-i18n="contact.phone">Phone</span></label><input class="form-control" name="phone"></div>
                        <div class="col-md-6"><label class="form-label"><i class="far fa-building"></i><span data-i18n="contact.company">Company</span></label><input class="form-control" name="company"></div>
                        <div class="col-12"><label class="form-label"><i class="fas fa-heading"></i><span data-i18n="contact.subject">Subject</span></label><input class="form-control" name="subject" data-i18n-placeholder="contact.subjectPlaceholder" placeholder="Your inquiry subject"></div>
                        <div class="col-12"><label class="form-label"><i class="far fa-comment-dots"></i><span data-i18n="contact.message">Message</span></label><textarea class="form-control" name="message" rows="5"></textarea></div>
                        <div class="col-12 d-grid d-md-flex justify-content-md-end"><button class="btn contact-submit px-5 text-white"><i class="fas fa-paper-plane me-2"></i><span data-i18n="contact.submit">Submit Contact Request</span></button></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
</div>
@endsection
