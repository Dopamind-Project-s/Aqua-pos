@extends('layouts.app')

@push('styles')
<style>
    .product-show-page { background: linear-gradient(180deg, #f3f7ff 0%, #fff 100%); padding-top: clamp(5.2rem, 7vw, 6.6rem); }
    .section-card { border: 1px solid #e1eaf9; border-radius: 18px; background: #fff; box-shadow: 0 10px 24px rgba(13,33,67,.08); }
    .show-hero { background: linear-gradient(130deg, #0f2f62 0%, #176ac4 58%, #3e91f3 100%); color: #fff; border-radius: 0 0 30px 30px; }
    .feature-chip { border: 1px solid #d3e4fc; background: #f3f8ff; color: #175cad; border-radius: 999px; padding: .5rem .8rem; font-weight: 700; font-size: 13px; }
    .journey-step { border-inline-start: 4px solid #2d7edf; padding-inline-start: 1rem; }
    .related-item { border: 1px solid #e2ebfa; border-radius: 12px; padding: 1rem; background: #fff; }

    body.dark-mode .product-show-page { background: linear-gradient(180deg, #0e1728 0%, #0b1420 100%); }
    body.dark-mode .section-card,
    body.dark-mode .related-item,
    body.dark-mode .feature-chip { background: #121c2c; border-color: #2a3d5a; color: #dce9fd; }
    body.dark-mode .text-muted { color: #adc4e6 !important; }
</style>
@endpush

@section('content')
<div class="product-show-page">
    <section class="show-hero py-5 mb-4">
        <div class="container py-4">
            <span class="badge bg-light text-dark mb-3">{{ $product->category?->localized_name }}</span>
            <h1 class="display-5 fw-bold mb-2">{{ $product->localized_name }}</h1>
            <p class="lead mb-3">{{ $product->localized_tagline ?: $product->localized_short_description }}</p>
            <div class="d-flex gap-2 flex-wrap">
                <a href="{{ route('request-product-demo') }}" class="btn btn-light rounded-pill" data-i18n="products.requestDemo">Request Demo</a>
                <a href="{{ route('products') }}" class="btn btn-outline-light rounded-pill" data-i18n="products.back">Back to Products</a>
            </div>
        </div>
    </section>

    <section class="pb-5">
        <div class="container d-grid gap-4">
            <div class="section-card overflow-hidden">
                <div class="row g-0 align-items-stretch">
                    <div class="col-lg-5"><img src="{{ $product->image ? Storage::url($product->image) : asset('img/service-1.jpg') }}" alt="{{ $product->localized_name }}" class="w-100 h-100" style="min-height: 300px; object-fit: cover;"></div>
                    <div class="col-lg-7 p-4 p-lg-5">
                        <h2 class="h4 mb-3" data-i18n="products.about">About this product</h2>
                        <p class="text-muted mb-4">{{ $product->localized_description ?: $product->localized_short_description }}</p>
                        <div class="d-flex flex-wrap gap-2 mb-4">
                            @foreach(($product->key_features ?? []) as $feature)
                                <span class="feature-chip"><i class="fas fa-check-circle me-1"></i>{{ $feature }}</span>
                            @endforeach
                        </div>
                        @if(!is_null($product->price))
                            <p class="h5 text-primary mb-0">{{ $product->price_note ?: 'Starting from' }} {{ number_format((float) $product->price, 0) }}</p>
                        @endif
                    </div>
                </div>
            </div>

            <div class="section-card p-4">
                <h3 class="h5 mb-3" data-i18n="products.useCases">Use Cases</h3>
                <p class="text-muted mb-0">{{ $product->localized_use_cases ?: __('Designed to streamline operations, improve checkout speed, and unify reporting across outlets.') }}</p>
            </div>

            <div class="section-card p-4">
                <h3 class="h5 mb-3" data-i18n="products.journeyTitle">Implementation Journey</h3>
                <div class="row g-3">
                    <div class="col-md-4"><div class="journey-step"><h6 data-i18n="products.journey1Title">Discover</h6><p class="small text-muted mb-0" data-i18n="products.journey1Desc">Understand your current operation model and branch requirements.</p></div></div>
                    <div class="col-md-4"><div class="journey-step"><h6 data-i18n="products.journey2Title">Deploy</h6><p class="small text-muted mb-0" data-i18n="products.journey2Desc">Configure products, users, inventory, printers, and integrations.</p></div></div>
                    <div class="col-md-4"><div class="journey-step"><h6 data-i18n="products.journey3Title">Optimize</h6><p class="small text-muted mb-0" data-i18n="products.journey3Desc">Track KPIs and continuously refine staff and process performance.</p></div></div>
                </div>
            </div>

            @if($relatedProducts->isNotEmpty())
                <div class="section-card p-4">
                    <h3 class="h5 mb-3" data-i18n="products.related">Related Products</h3>
                    <div class="row g-3">
                        @foreach($relatedProducts as $related)
                            <div class="col-md-6 col-xl-3">
                                <article class="related-item h-100">
                                    <h6>{{ $related->localized_name }}</h6>
                                    <p class="small text-muted">{{ $related->localized_short_description }}</p>
                                    <a href="{{ route('products.show', $related->slug) }}" class="btn btn-sm btn-outline-primary rounded-pill" data-i18n="products.viewDetails">View Details</a>
                                </article>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </section>
</div>
@endsection
