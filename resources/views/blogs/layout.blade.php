@extends('layouts.app')

@push('styles')
<style>
    .blogs-shell {
        background: radial-gradient(circle at top right, #f4f8ff 0%, #eef3fb 48%, #eaf1fc 100%);
        padding-top: 0;
    }

    .blog-page-hero {
        height: clamp(390px, 32vw, 520px);
        min-height: clamp(390px, 32vw, 520px);
        margin-top: 0;
        margin-bottom: clamp(1.75rem, 3vw, 2.75rem);
        display: flex;
        align-items: center;
        color: #fff;
        position: relative;
        overflow: hidden;
        border-radius: 0 0 22px 22px;
        background: linear-gradient(135deg, #0d2344 0%, #154a8f 56%, #2673d6 100%);
        isolation: isolate;
    }

    .blog-page-hero::after {
        content: "";
        position: absolute;
        width: 420px;
        height: 420px;
        border-radius: 50%;
        top: -155px;
        inset-inline-end: -120px;
        background: rgba(255, 255, 255, .14);
        z-index: -1;
    }

    .blog-page-hero .container {
        min-height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .blog-page-hero__content {
        width: min(100%, 920px);
        margin-inline: auto;
        text-align: center;
        padding-top: clamp(5.8rem, 8vw, 6.8rem);
    }

    .blog-page-hero h1 {
        color: #fff;
        font-size: clamp(3rem, 5vw, 5rem);
        line-height: 1.08;
        margin-bottom: 1rem;
        text-shadow: 0 10px 28px rgba(4, 21, 48, .2);
    }

    .blog-page-hero p {
        width: min(100%, 760px);
        margin: 0 auto;
        color: rgba(255, 255, 255, .9);
        font-size: clamp(1rem, 1.45vw, 1.18rem);
        line-height: 1.7;
    }

    .blog-hero-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        border-radius: 999px;
        padding: 8px 14px;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .04em;
        border: 1px solid rgba(255, 255, 255, .28);
        background: rgba(255, 255, 255, .14);
        color: #fff;
    }

    .blog-hero-badge--primary { background: rgba(255, 255, 255, .14); color: #fff; }
    .blog-hero-badge--success { background: rgba(255, 255, 255, .14); color: #fff; }

    .blog-slider .owl-dots {
        position: absolute;
        inset-inline: 0;
        bottom: 16px;
        z-index: 3;
    }

    .blog-slider .owl-dot span {
        width: 11px !important;
        height: 11px !important;
        background: rgba(255,255,255,.5) !important;
    }

    .blog-slider .owl-dot.active span { background: #fff !important; }

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

    .article-page-head {
        background: linear-gradient(135deg, #ffffff, #f4f8ff);
        border: 1px solid #e3eaf7;
        border-radius: 20px;
        padding: clamp(16px, 2.8vw, 28px);
        box-shadow: 0 10px 26px rgba(16, 30, 54, .08);
    }

    .article-page-head__eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        border-radius: 999px;
        background: #e9f1ff;
        color: #0f4b97;
        font-weight: 700;
        font-size: 12px;
        padding: 6px 12px;
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

    .social-share a {
        width: 40px;
        height: 40px;
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        color: #fff;
        transition: transform .2s ease, filter .2s ease;
    }
    .social-share a:hover { transform: translateY(-2px); filter: brightness(1.05); }
    .social-share .social-facebook { background: #1877f2; }
    .social-share .social-twitter { background: #1d9bf0; }
    .social-share .social-linkedin { background: #0a66c2; }
    .social-share .social-whatsapp { background: #25d366; }

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
    [dir="rtl"] .calendar-meta,
    [dir="rtl"] .article-page-head {
        text-align: right;
    }

    body.dark-mode .blogs-shell { background: linear-gradient(180deg, #0f1725 0%, #0c1420 100%); }
    body.dark-mode .blog-sidebar-card,
    body.dark-mode .article-shell,
    body.dark-mode .inner-mini-nav,
    body.dark-mode .blog-card,
    body.dark-mode .article-page-head {
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
    body.dark-mode .calendar-meta strong,
    body.dark-mode .article-page-head,
    body.dark-mode .article-page-head h1 {
        color: #e7edf8 !important;
    }
    body.dark-mode .mini-nav-chip { background: #18243a; border-color: #2a3a54; }
    body.dark-mode .mini-nav-chip.active { background: linear-gradient(135deg, #1f63bc, #2a79df); }
    body.dark-mode .calendar-meta small,
    body.dark-mode .blog-card .meta,
    body.dark-mode .text-muted { color: #9ab0cf !important; }
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
        .blog-page-hero {
            height: clamp(370px, 48vw, 460px);
            min-height: clamp(370px, 48vw, 460px);
        }
        .blog-page-hero__content {
            padding-top: clamp(5rem, 11vw, 6rem);
        }
        .blog-page-hero h1 {
            font-size: clamp(2.3rem, 7vw, 3.2rem);
        }
    }

    @media (max-width: 576px) {
        .mini-nav-chip { width: 100%; justify-content: center; }
        .mini-nav-dropdown,
        .mini-nav-dropdown .mini-nav-chip { width: 100%; }
        .mini-nav-chip--calendar,
        .mini-nav-chip--clock { justify-content: flex-start; }
        .blog-page-hero {
            height: 390px;
            min-height: 390px;
            border-radius: 0 0 18px 18px;
        }
        .blog-page-hero::after {
            width: 320px;
            height: 320px;
            top: -105px;
            inset-inline-end: -150px;
        }
        .blog-page-hero__content {
            width: min(100%, 18rem);
            padding-top: 4.5rem;
        }
        .blog-page-hero h1 {
            font-size: clamp(1.65rem, 7.5vw, 2rem);
            line-height: 1.14;
            overflow-wrap: break-word;
        }
        .blog-page-hero p {
            font-size: .92rem;
            line-height: 1.55;
            overflow-wrap: break-word;
        }
    }
</style>
@endpush

@section('content')
<div class="blogs-shell pb-5">
    @yield('blog-content')
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const initBlogSlider = function () {
            const $slider = $('.blog-slider');
            if (!$slider.length) return;

            if ($slider.hasClass('owl-loaded')) {
                $slider.trigger('destroy.owl.carousel');
                $slider.removeClass('owl-loaded');
                $slider.find('.owl-stage-outer').children().unwrap();
            }

            $slider.owlCarousel({
                items: 1,
                loop: true,
                autoplay: true,
                autoplayTimeout: 5000,
                smartSpeed: 800,
                dots: true,
                nav: false,
                rtl: document.documentElement.getAttribute('dir') === 'rtl',
            });
        };

        initBlogSlider();
        document.addEventListener('aqua:language-changed', initBlogSlider);
    });
</script>
@endpush
