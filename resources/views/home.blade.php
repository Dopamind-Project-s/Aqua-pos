@extends('layouts.app')

@section('content')
@php($showCarousel = true)

@include('home.sections.category-explorer')
@include('home.sections.about')
@include('home.sections.feature')
@include('home.sections.appointment')
@include('home.sections.clients')
@include('home.sections.blog')
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const el = document.querySelector('.clients-swiper');
        if (!el) return;

        let clientsSwiper;

        const initClientsSwiper = function () {
            if (clientsSwiper) {
                clientsSwiper.destroy(true, true);
            }

            clientsSwiper = new Swiper(el, {
                slidesPerView: 2,
                spaceBetween: 14,
                autoplay: { delay: 2600, disableOnInteraction: false },
                loop: true,
                rtl: document.documentElement.getAttribute('dir') === 'rtl',
                breakpoints: {
                    640: { slidesPerView: 3 },
                    768: { slidesPerView: 4 },
                    1200: { slidesPerView: 6 }
                }
            });
        };

        initClientsSwiper();
        document.addEventListener('aqua:language-changed', initClientsSwiper);
    });
</script>
@endpush
