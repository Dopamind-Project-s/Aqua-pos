@extends('layouts.app')

@push('styles')
<style>
    .blogs-shell {
        background: radial-gradient(circle at top right, #f4f8ff 0%, #eef3fb 48%, #eaf1fc 100%);
    }

    .blog-slider-wrap { margin-top: 0; }
    .blog-slide-item { position: relative; border-radius: 22px; overflow: hidden; }
    .blog-slide-item img { width: 100%; height: clamp(280px, 42vw, 460px); object-fit: cover; filter: brightness(0.52); }
    .blog-slide-content { position: absolute; inset: 0; display: flex; align-items: center; }
    .blog-slide-content .inner { color: #fff; max-width: 760px; padding: 24px 40px; }

    .blog-card {
        border: 1px solid #e5eaf3;
        border-radius: 18px;
        overflow: hidden;
        box-shadow: 0 10px 28px rgba(16, 30, 54, .08);
        transition: transform .25s ease, box-shadow .25s ease;
    }
    .blog-card:hover { transform: translateY(-4px); box-shadow: 0 16px 34px rgba(16, 30, 54, .12); }
    .blog-card .thumb { width: 100%; height: 230px; object-fit: cover; }
    .thumb--placeholder,
    .article-cover--placeholder,
    .sidebar-thumb--placeholder {
        background: linear-gradient(140deg, #eef4ff, #dce8ff);
        color: #2d5da7;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        gap: 8px;
    }
    .thumb--placeholder i,
    .article-cover--placeholder i { font-size: 1.6rem; opacity: .9; }
    .thumb--placeholder span,
    .article-cover--placeholder span { font-size: 12px; font-weight: 700; }

    .blog-card .meta { font-size: 12px; color: #667085; }
    .blog-sidebar-card {
        background: #fff;
        border-radius: 18px;
        padding: 22px;
        border: 1px solid #e8edf6;
        box-shadow: 0 8px 22px rgba(16, 30, 54, .06);
    }
    .badge-soft { background: #e8f1ff; color: #0d4f99; border-radius: 20px; padding: 4px 10px; font-size: 11px; }
    .sidebar-thumb {
        width: 68px;
        height: 68px;
        border-radius: 10px;
        object-fit: cover;
        flex-shrink: 0;
        border: 1px solid rgba(20, 44, 82, .08);
    }

    .article-shell {
        background: #fff;
        border-radius: 20px;
        padding: 28px;
        border: 1px solid #e6ecf7;
        box-shadow: 0 12px 26px rgba(16, 30, 54, .08);
    }
    .article-cover { border-radius: 16px; max-height: 440px; width: 100%; object-fit: cover; }
    .article-cover--placeholder { min-height: 320px; border-radius: 16px; }
    .article-content { line-height: 1.95; color: #1d2939; font-size: 17px; }
    .social-share a { width: 38px; height: 38px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; background: #f1f5ff; color: #1454a8; text-decoration: none; }

    .inner-mini-nav-wrap { display: flex; justify-content: center; }
    .inner-mini-nav {
        width: min(100%, 980px);
        background: #ffffff;
        border: 1px solid #e4e7ec;
        border-radius: 16px;
        padding: 10px 12px;
        box-shadow: 0 10px 20px rgba(15, 23, 42, .08);
    }
    .mini-nav-chip {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
        color: #164f97;
        background: #edf4ff;
        border: 1px solid #d9e7ff;
        border-radius: 12px;
        padding: 8px 12px;
        font-size: 12px;
        font-weight: 700;
        line-height: 1.2;
        min-height: 42px;
    }
    .mini-nav-chip--switch { border-radius: 999px; }
    .mini-nav-chip.active { background: linear-gradient(135deg, #195eb7, #0f4a96); color: #fff; border-color: transparent; }
    .mini-nav-chip--category strong { color: #0f3c79; }
    .mini-nav-chip--category::after { margin-left: 2px; }
    .mini-nav-dropdown-menu { border-radius: 14px; border: 1px solid #dfe8f8; min-width: 240px; }
    .mini-nav-chip--calendar,
    .mini-nav-chip--clock { background: #fff; }
    .calendar-meta { display: grid; }
    .calendar-meta small { font-size: 10px; color: #667085; text-transform: uppercase; letter-spacing: .04em; }
    .calendar-meta strong { font-size: 12px; color: #123f7d; }

    [dir="rtl"] .mini-nav-chip,
    [dir="rtl"] .mini-nav-chip--category,
    [dir="rtl"] .calendar-meta {
        text-align: right;
    }

    body.dark-mode .blogs-shell { background: linear-gradient(180deg, #0f1725 0%, #0c1420 100%); }
    body.dark-mode .blog-sidebar-card,
    body.dark-mode .article-shell,
    body.dark-mode .inner-mini-nav,
    body.dark-mode .blog-card {
        background: #121b2b;
        border-color: #243247;
        box-shadow: 0 8px 24px rgba(0,0,0,.35);
    }
    body.dark-mode .article-content,
    body.dark-mode .blog-card .card-title,
    body.dark-mode .blog-sidebar-card .text-dark,
    body.dark-mode .blog-sidebar-card .fw-semibold,
    body.dark-mode .mini-nav-chip,
    body.dark-mode .mini-nav-chip strong,
    body.dark-mode .calendar-meta strong {
        color: #e7edf8 !important;
    }
    body.dark-mode .mini-nav-chip { background: #18243a; border-color: #2a3a54; }
    body.dark-mode .mini-nav-chip.active { background: linear-gradient(135deg, #1f63bc, #2a79df); }
    body.dark-mode .calendar-meta small,
    body.dark-mode .blog-card .meta,
    body.dark-mode .text-muted { color: #9ab0cf !important; }
    body.dark-mode .social-share a { background: #1b2740; color: #9bc2ff; }
    body.dark-mode .mini-nav-dropdown-menu { background: #162234; border-color: #2a3a54; }
    body.dark-mode .mini-nav-dropdown-menu .dropdown-item-text,
    body.dark-mode .mini-nav-dropdown-menu .dropdown-header { color: #d9e6fb; }
    body.dark-mode .thumb--placeholder,
    body.dark-mode .article-cover--placeholder,
    body.dark-mode .sidebar-thumb--placeholder { background: linear-gradient(140deg, #21304a, #16243a); color: #aacbff; }

    @media (max-width: 992px) {
        .blog-card .thumb { height: 210px; }
        .article-shell { padding: 20px; }
        .inner-mini-nav { width: 100%; }
    }

    @media (max-width: 576px) {
        .mini-nav-chip { width: 100%; justify-content: center; }
        .mini-nav-dropdown,
        .mini-nav-dropdown .mini-nav-chip { width: 100%; }
        .mini-nav-chip--calendar,
        .mini-nav-chip--clock { justify-content: flex-start; }
        .blog-slide-content .inner { padding: 18px; }
    }
</style>
@endpush

@section('content')
<div class="blogs-shell py-5">
    @yield('blog-content')
</div>
@endsection

@push('scripts')
<script>
    $('.blog-slider').owlCarousel({
        items: 1,
        loop: true,
        autoplay: true,
        autoplayTimeout: 5000,
        smartSpeed: 800,
        dots: true,
        nav: false,
    });
</script>
@endpush
