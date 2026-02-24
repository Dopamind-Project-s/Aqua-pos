@extends('layouts.app')

@push('styles')
<style>
    .blogs-shell { background: linear-gradient(180deg, #f7f9ff 0%, #eef3fb 100%); }
    .blog-slider-wrap { margin-top: 0; }
    .blog-slide-item { position: relative; border-radius: 20px; overflow: hidden; }
    .blog-slide-item img { width: 100%; height: 460px; object-fit: cover; filter: brightness(0.55); }
    .blog-slide-content { position: absolute; inset: 0; display: flex; align-items: center; }
    .blog-slide-content .inner { color: #fff; max-width: 700px; padding: 24px 40px; }

    .post-mini-nav { background: #fff; border: 1px solid #e4e7ec; border-radius: 14px; padding: 10px 16px; box-shadow: 0 8px 20px rgba(15, 23, 42, .06); }
    .post-mini-nav .chip { display: inline-flex; align-items: center; gap: 8px; background: #f3f7ff; color: #1d4f91; border-radius: 999px; padding: 8px 12px; font-size: 13px; font-weight: 600; }

    .blog-card { border: 0; border-radius: 18px; overflow: hidden; box-shadow: 0 12px 30px rgba(16, 30, 54, .1); }
    .blog-card .thumb { width: 100%; height: 230px; object-fit: cover; }
    .blog-card .meta { font-size: 13px; color: #667085; }
    .blog-sidebar-card { background: #fff; border-radius: 18px; padding: 22px; box-shadow: 0 10px 24px rgba(16, 30, 54, .08); }
    .badge-soft { background: #e8f1ff; color: #0d4f99; border-radius: 20px; padding: 6px 12px; font-size: 12px; }

    .article-shell { background: #fff; border-radius: 20px; padding: 28px; box-shadow: 0 12px 26px rgba(16, 30, 54, .08); }
    .article-cover { border-radius: 16px; max-height: 440px; width: 100%; object-fit: cover; }
    .article-content { line-height: 1.95; color: #1d2939; font-size: 17px; }
    .social-share a { width: 38px; height: 38px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; background: #f1f5ff; color: #1454a8; text-decoration: none; }

    .inner-mini-nav-wrap { display: flex; justify-content: center; }
    .inner-mini-nav {
        width: 50%;
        min-width: 320px;
        background: #ffffff;
        border: 1px solid #e4e7ec;
        border-radius: 16px;
        padding: 10px 12px;
        box-shadow: 0 10px 20px rgba(15, 23, 42, .08);
    }
    .mini-nav-chip {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        text-decoration: none;
        color: #1856a9;
        background: #eef4ff;
        border-radius: 999px;
        padding: 6px 10px;
        font-size: 12px;
        font-weight: 700;
    }
    .mini-nav-chip.active {
        background: #1856a9;
        color: #fff;
    }
    @media (max-width: 992px) {
        .inner-mini-nav { width: 100%; }
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
