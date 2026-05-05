@extends('layouts.app')

@push('styles')
<style>
    .product-show-page {
        --aqua-900: #0f3a52;
        --aqua-700: #0d6d8d;
        --aqua-500: #11a1bd;
        --surface: #ffffff;
        --surface-soft: #f4fbfd;
        --border-soft: #d6ecf2;
        --text-main: #163041;
        --text-soft: #4f6470;
        background: radial-gradient(circle at 8% 0%, #e9f9fd 0%, #f6fbff 34%, #ffffff 100%);
        padding-top: clamp(5.2rem, 7vw, 6.8rem);
        color: var(--text-main);
    }

    .show-hero {
        background: linear-gradient(130deg, var(--aqua-900) 0%, var(--aqua-700) 55%, var(--aqua-500) 100%);
        color: #f7fdff;
        border-radius: 0 0 30px 30px;
    }

    .product-category-badge {
        border-radius: 999px;
        font-size: clamp(.95rem, 1vw, 1.08rem);
        padding: .52rem .9rem;
        letter-spacing: 0;
    }

    .product-hero-gallery {
        background: rgba(255, 255, 255, .12);
        border: 1px solid rgba(255, 255, 255, .24);
        border-radius: 18px;
        padding: .7rem;
        backdrop-filter: blur(6px);
        box-shadow: 0 24px 50px rgba(7, 33, 48, .22);
    }

    .product-hero-gallery .carousel-inner {
        border-radius: 14px;
        overflow: hidden;
        background: rgba(255, 255, 255, .16);
    }

    .product-hero-slide {
        aspect-ratio: 4 / 3;
        background: linear-gradient(135deg, rgba(255, 255, 255, .92), rgba(228, 247, 252, .86));
    }

    .product-hero-slide img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        padding: .55rem;
    }

    .product-hero-thumbs {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(58px, 1fr));
        gap: .5rem;
        margin-top: .65rem;
    }

    .product-hero-thumb {
        border: 1px solid rgba(255, 255, 255, .32);
        border-radius: 10px;
        padding: 0;
        overflow: hidden;
        background: rgba(255, 255, 255, .14);
        aspect-ratio: 1 / 1;
        opacity: .72;
        transition: opacity .2s ease, transform .2s ease, border-color .2s ease;
    }

    .product-hero-thumb.active,
    .product-hero-thumb:hover {
        opacity: 1;
        border-color: #fff;
        transform: translateY(-1px);
    }

    .product-hero-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .product-hero-gallery .carousel-control-prev,
    .product-hero-gallery .carousel-control-next {
        width: 2.5rem;
        height: 2.5rem;
        top: 50%;
        transform: translateY(-50%);
        margin-inline: .5rem;
        border-radius: 50%;
        background: rgba(6, 35, 51, .45);
    }

    .show-cta { display: flex; flex-wrap: wrap; gap: .6rem; }

    .section-card {
        border: 1px solid var(--border-soft);
        border-radius: 20px;
        background: var(--surface);
        box-shadow: 0 14px 30px rgba(15, 58, 82, .08);
    }

    .product-media-frame {
        min-height: clamp(300px, 34vw, 520px);
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 1rem;
        background: linear-gradient(135deg, #f5fbfd, #eaf8fc);
    }

    .product-media {
        width: 100%;
        max-height: 620px;
        object-fit: contain;
    }

    .product-copy { color: var(--text-soft); line-height: 1.8; margin-bottom: 1.2rem; }

    .feature-chip {
        border: 1px solid #cde9f1;
        background: #eef9fc;
        color: #0d6d8d;
        border-radius: 999px;
        padding: .42rem .72rem;
        font-weight: 700;
        font-size: 12px;
    }

    .info-tile {
        border: 1px solid var(--border-soft);
        background: var(--surface-soft);
        border-radius: 12px;
        padding: .75rem .85rem;
    }

    .info-tile small { color: var(--text-soft); display: block; margin-bottom: .2rem; }
    .info-tile strong { color: var(--text-main); font-size: .95rem; }

    .journey-step {
        border-inline-start: 3px solid #13a0bc;
        padding-inline-start: .9rem;
    }

    .related-item {
        border: 1px solid var(--border-soft);
        border-radius: 14px;
        padding: 1rem;
        background: var(--surface);
        height: 100%;
        box-shadow: 0 8px 20px rgba(15, 58, 82, .06);
    }

    .related-item h6 { margin-bottom: .45rem; color: var(--text-main); }
    .product-show-page .text-muted { color: var(--text-soft) !important; }

    body.dark-mode .product-show-page {
        --surface: #111d2a;
        --surface-soft: #162638;
        --border-soft: #244055;
        --text-main: #e5f6ff;
        --text-soft: #abc8d7;
        background: radial-gradient(circle at 8% 0%, #0d2230 0%, #0a1622 52%, #09131e 100%);
    }

    body.dark-mode .section-card,
    body.dark-mode .related-item,
    body.dark-mode .info-tile {
        box-shadow: 0 16px 28px rgba(0, 0, 0, .28);
    }

    body.dark-mode .feature-chip {
        background: #1a3345;
        border-color: #2b5368;
        color: #7fdaf0;
    }

    body.dark-mode .product-hero-gallery {
        background: rgba(7, 20, 32, .34);
        border-color: rgba(139, 218, 238, .22);
    }

    body.dark-mode .product-media-frame {
        background: linear-gradient(135deg, #13293a, #0f2232);
    }

    body.dark-mode .btn-outline-primary {
        color: #86ddf2;
        border-color: #3f6d84;
    }

    body.dark-mode .btn-outline-primary:hover {
        background: #1b3445;
        color: #dff8ff;
        border-color: #4f8da8;
    }
</style>
@endpush

@section('content')
@php($gallerySlides = $product->gallery_slides)
@php($hasGalleryCarousel = $gallerySlides->count() > 1)

<div class="product-show-page">
    <section class="show-hero py-5 mb-4">
        <div class="container py-4">
            <div class="row g-4 align-items-center">
                <div class="col-lg-8">
                    <span class="badge bg-light text-dark mb-3 product-category-badge">{{ $product->category?->localized_name }}</span>
                    <h1 class="display-5 fw-bold mb-2">{{ $product->localized_name }}</h1>
                    <p class="lead mb-3">{{ $product->localized_tagline ?: $product->localized_short_description }}</p>
                    <div class="show-cta">
                        <a href="{{ route('request-product-demo') }}" class="btn btn-light rounded-pill" data-i18n="products.requestDemo">Request Demo</a>
                        <a href="{{ route('products') }}" class="btn btn-outline-light rounded-pill" data-i18n="products.back">Back to Products</a>
                        <a href="{{ route('products') }}" class="btn btn-primary rounded-pill" data-i18n="products.allProducts">View All Products</a>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="product-hero-gallery">
                        <div id="productHeroGallery" class="carousel slide" @if($hasGalleryCarousel) data-bs-ride="carousel" data-bs-interval="4200" @endif>
                            <div class="carousel-inner">
                                @foreach($gallerySlides as $slide)
                                    <div class="carousel-item @if($loop->first) active @endif">
                                        <div class="product-hero-slide">
                                            <img src="{{ $slide['url'] }}" alt="{{ $slide['alt'] }}" loading="{{ $loop->first ? 'eager' : 'lazy' }}" decoding="async">
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            @if($hasGalleryCarousel)
                                <button class="carousel-control-prev" type="button" data-bs-target="#productHeroGallery" data-bs-slide="prev" aria-label="Previous product image">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#productHeroGallery" data-bs-slide="next" aria-label="Next product image">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                </button>
                            @endif
                        </div>

                        @if($hasGalleryCarousel)
                            <div class="product-hero-thumbs" aria-label="Product gallery images">
                                @foreach($gallerySlides as $slide)
                                    <button type="button" class="product-hero-thumb @if($loop->first) active @endif" data-bs-target="#productHeroGallery" data-bs-slide-to="{{ $loop->index }}" aria-label="{{ $slide['label'] }} {{ $loop->iteration }}">
                                        <img src="{{ $slide['url'] }}" alt="{{ $slide['alt'] }}" loading="lazy" decoding="async">
                                    </button>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="pb-5">
        <div class="container d-grid gap-4">
            <div class="section-card overflow-hidden">
                <div class="row g-0 align-items-stretch">
                    <div class="col-lg-5">
                        <div class="product-media-frame">
                            <img src="{{ $product->image_url }}" alt="{{ $product->localized_name }}" class="product-media" loading="lazy" decoding="async">
                        </div>
                    </div>
                    <div class="col-lg-7 p-4 p-lg-5">
                        <p class="product-copy">{{ $product->localized_description ?: $product->localized_short_description }}</p>
                        <div class="d-flex flex-wrap gap-2 mb-4">
                            @foreach(($product->key_features ?? []) as $feature)
                                <span class="feature-chip"><i class="fas fa-check-circle me-1"></i>{{ $feature }}</span>
                            @endforeach
                        </div>
                        <div class="row g-2">
                            <div class="col-sm-6">
                                <div class="info-tile">
                                    <small>Category</small>
                                    <strong>{{ $product->category?->localized_name ?: '-' }}</strong>
                                </div>
                            </div>
                            @if(!is_null($product->price))
                                <div class="col-sm-6">
                                    <div class="info-tile">
                                        <small>{{ $product->price_note ?: 'Starting from' }}</small>
                                        <strong>{{ number_format((float) $product->price, 0) }}</strong>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="section-card p-4">
                <h3 class="h5 mb-3" data-i18n="products.useCases">Use Cases</h3>
                <p class="text-muted mb-0">{{ $product->localized_use_cases ?: '' }}<span @if($product->localized_use_cases) class="d-none" @endif data-i18n="products.useCasesFallback">Designed to streamline operations, improve checkout speed, and unify reporting across outlets.</span></p>
            </div>

            <div class="section-card p-4">
                <h3 class="h5 mb-3" data-i18n="products.journeyTitle">Implementation Journey</h3>
                <div class="row g-3">
                    <div class="col-md-4"><div class="journey-step"><h6 data-i18n="products.journey1Title">Discover</h6><p class="small text-muted mb-0" data-i18n="products.journey1Desc">Understand your current operation model and branch requirements.</p></div></div>
                    <div class="col-md-4"><div class="journey-step"><h6 data-i18n="products.journey2Title">Deploy</h6><p class="small text-muted mb-0" data-i18n="products.journey2Desc">Configure products, users, inventory, printers, and integrations.</p></div></div>
                    <div class="col-md-4"><div class="journey-step"><h6 data-i18n="products.journey3Title">Optimize</h6><p class="small text-muted mb-0" data-i18n="products.journey3Desc">Track KPIs and continuously refine staff and process performance.</p></div></div>
                </div>
            </div>

            <div class="section-card p-4">
                <div class="d-flex justify-content-between align-items-center mb-3 gap-2 flex-wrap">
                    <h3 class="h5 mb-0" data-i18n="products.related">Related Products</h3>
                    <a href="{{ route('products') }}" class="btn btn-outline-primary rounded-pill btn-sm" data-i18n="products.allProducts">View All Products</a>
                </div>
                <div class="row g-3">
                    @forelse($relatedProducts as $related)
                        <div class="col-md-6 col-xl-3">
                            <article class="related-item">
                                <h6>{{ $related->localized_name }}</h6>
                                <p class="small text-muted">{{ $related->localized_short_description }}</p>
                                <a href="{{ route('products.show', $related->slug) }}" class="btn btn-sm btn-outline-primary rounded-pill" data-i18n="products.viewDetails">View Details</a>
                            </article>
                        </div>
                    @empty
                        <div class="col-12"><div class="alert alert-light border" data-i18n="products.noRelated">No related products available yet.</div></div>
                    @endforelse
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var gallery = document.getElementById('productHeroGallery');

        if (!gallery) {
            return;
        }

        var thumbs = document.querySelectorAll('.product-hero-thumb');

        gallery.addEventListener('slid.bs.carousel', function (event) {
            thumbs.forEach(function (thumb, index) {
                thumb.classList.toggle('active', index === event.to);
            });
        });
    });
</script>
@endpush
