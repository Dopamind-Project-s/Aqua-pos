@extends('layouts.app')

@push('styles')
<style>
    .support-page {
        background: radial-gradient(circle at top right, #eef5ff 0%, #f7fbff 52%, #ffffff 100%);
        padding-top: clamp(5.2rem, 7vw, 6.6rem);
    }

    .support-hero {
        background: linear-gradient(135deg, #0d2344 0%, #154a8f 58%, #2673d6 100%);
        color: #fff;
        border-radius: 0 0 22px 22px;
        position: relative;
        overflow: hidden;
    }

    .support-hero::after {
        content: "";
        position: absolute;
        width: 360px;
        height: 360px;
        border-radius: 50%;
        top: -150px;
        inset-inline-end: -120px;
        background: rgba(255, 255, 255, .14);
    }

    .support-hero .container { position: relative; z-index: 2; }

    .support-badge {
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

    .support-grid-card {
        border: 1px solid #deebfb;
        border-radius: 18px;
        background: #fff;
        box-shadow: 0 12px 26px rgba(13, 32, 67, .08);
    }

    .support-tile {
        background: linear-gradient(180deg, #ffffff 0%, #f8fbff 100%);
        border: 1px solid #e5edf9;
        border-radius: 14px;
        padding: 18px;
    }

    .support-icon {
        width: 46px;
        height: 46px;
        border-radius: 12px;
        background: linear-gradient(140deg, #eaf3ff, #dceaff);
        color: #1558ad;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
    }

    .support-form .form-label {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        font-weight: 600;
        color: #1f3759;
    }

    .support-form .form-control {
        border-radius: 12px;
        border-color: #d7e3f4;
        min-height: 48px;
    }

    .support-country-chip {
        min-height: 48px;
        display: block;
        padding: 10px 12px;
        border: 1px solid #d7e3f4;
        border-radius: 12px;
        background: #f6f9ff;
        color: #1f3759;
        font-weight: 600;
    }

    .support-form textarea.form-control { min-height: 140px; }

    .support-form .form-control:focus {
        border-color: #2f7fe1;
        box-shadow: 0 0 0 .18rem rgba(47, 127, 225, .14);
    }

    .support-submit {
        min-height: 52px;
        border-radius: 12px;
        font-weight: 700;
    }

    body.dark-mode .support-page { background: linear-gradient(180deg, #0f1726 0%, #0b1420 100%); }
    body.dark-mode .support-grid-card,
    body.dark-mode .support-tile {
        background: #121c2c;
        border-color: #253650;
        box-shadow: 0 12px 26px rgba(0,0,0,.34);
    }

    body.dark-mode .support-form .form-label,
    body.dark-mode .support-grid-card h3,
    body.dark-mode .support-grid-card h6,
    body.dark-mode .support-grid-card p,
    body.dark-mode .support-grid-card small,
    body.dark-mode .support-grid-card .text-muted {
        color: #dbe7fb !important;
    }

    body.dark-mode .support-form .form-control,
    body.dark-mode .support-country-chip {
        background: #101a2a;
        border-color: #2a3f5d;
        color: #e7edf9;
    }

    body.dark-mode .support-icon {
        background: linear-gradient(140deg, #20314b, #192840);
        color: #9bc2ff;
    }

    @media (max-width: 576px) {
        .support-page { padding-top: 4.7rem; }
        .support-hero { text-align: center; border-radius: 0 0 18px 18px; }
        .support-badge { justify-content: center; }
    }
</style>
@endpush

@section('content')
<div class="support-page">
@include('partials.page-hero', [
    'offset' => false,
    'icon' => 'fas fa-life-ring',
    'badge' => 'Support Center',
    'badgeI18n' => 'support.badge',
    'title' => 'How can we help you today?',
    'titleI18n' => 'support.title',
    'subtitle' => 'Raise a technical or operational issue and our support team will respond quickly.',
    'subtitleI18n' => 'support.subtitle',
])

<section class="py-5">
    <div class="container">
        @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif

        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <div class="support-tile h-100">
                    <div class="support-icon mb-2"><i class="fas fa-microchip"></i></div>
                    <h6 data-i18n="support.tile1Title">Technical Support</h6>
                    <p class="mb-0 text-muted" data-i18n="support.tile1Desc">POS devices, printers, and app issues.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="support-tile h-100">
                    <div class="support-icon mb-2"><i class="fas fa-sliders-h"></i></div>
                    <h6 data-i18n="support.tile2Title">Setup Assistance</h6>
                    <p class="mb-0 text-muted" data-i18n="support.tile2Desc">Configuration and integration support.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="support-tile h-100">
                    <div class="support-icon mb-2"><i class="fas fa-user-shield"></i></div>
                    <h6 data-i18n="support.tile3Title">Account Help</h6>
                    <p class="mb-0 text-muted" data-i18n="support.tile3Desc">Users, permissions, and access issues.</p>
                </div>
            </div>
        </div>

        <div class="support-grid-card p-4 p-lg-5">
            <h3 class="mb-2"><i class="fas fa-headset text-primary me-2"></i><span data-i18n="support.formTitle">Submit Support Request</span></h3>
            <p class="text-muted mb-4" data-i18n="support.formSubtitle">Please provide as much detail as possible so we can resolve your issue faster.</p>

            <form method="POST" action="{{ route('requests.store') }}" class="row g-3 support-form">@csrf
                <input type="hidden" name="type" value="support_request">
                <input type="hidden" name="source_page" value="/support">

                <div class="col-md-6"><label class="form-label"><i class="far fa-user"></i><span data-i18n="support.fullName">Full Name</span></label><input class="form-control" name="full_name" required></div>
                <div class="col-md-6"><label class="form-label"><i class="far fa-envelope"></i><span data-i18n="support.email">Email</span></label><input type="email" class="form-control" name="email"></div>
                @include('requests.partials.country-field', [
                    'id' => 'supportCountry',
                    'i18nPrefix' => 'support',
                    'columnClass' => 'col-md-4',
                    'chipClass' => 'support-country-chip',
                ])
                <div class="col-md-4"><label class="form-label"><i class="fas fa-phone"></i><span data-i18n="support.phone">Phone</span></label><input class="form-control" name="phone" value="{{ old('phone') }}"></div>
                <div class="col-md-4"><label class="form-label"><i class="far fa-building"></i><span data-i18n="support.company">Company</span></label><input class="form-control" name="company" value="{{ old('company') }}"></div>
                <div class="col-12"><label class="form-label"><i class="fas fa-heading"></i><span data-i18n="support.subject">Subject</span></label><input class="form-control" name="subject" data-i18n-placeholder="support.subjectPlaceholder" placeholder="Issue title"></div>
                <div class="col-12"><label class="form-label"><i class="far fa-comment-dots"></i><span data-i18n="support.details">Support Details</span></label><textarea class="form-control" name="message" rows="6"></textarea></div>
                <div class="col-12 d-grid d-md-flex justify-content-md-end"><button class="btn btn-primary px-5 support-submit"><i class="fas fa-paper-plane me-2"></i><span data-i18n="support.submit">Submit Support Request</span></button></div>
            </form>
        </div>
    </div>
</section>
</div>
@endsection
