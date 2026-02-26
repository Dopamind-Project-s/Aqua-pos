@extends('layouts.app')

@section('content')
<section class="partners-hero">
    <div class="container">
        <div class="partners-hero__content text-center">
            <p class="partners-hero__eyebrow">Strategic Ecosystem</p>
            <h1 class="partners-hero__title">Our Trusted Partners</h1>
            <p class="partners-hero__subtitle">We collaborate with high-impact brands and technology leaders to deliver seamless, scalable, and future-ready solutions.</p>
        </div>
    </div>
</section>

<section class="partners-section py-5">
    <div class="container">
        <div class="partner-skeleton-grid" id="partnerSkeleton" aria-hidden="true">
            @for($i = 0; $i < 8; $i++)
                <div class="partner-skeleton-card"></div>
            @endfor
        </div>

        @if($partners->count())
            <div class="partners-grid d-none" id="partnersGrid">
                @foreach($partners as $partner)
                    <x-partner-card :partner="$partner" />
                @endforeach
            </div>

            <div class="mt-4 d-flex justify-content-center">
                {{ $partners->links() }}
            </div>
        @else
            <div class="partners-empty-state text-center">
                <div class="partners-empty-state__icon"><i class="fas fa-handshake"></i></div>
                <h2>No partners yet</h2>
                <p>We are currently onboarding exceptional partners. Please check back soon.</p>
            </div>
        @endif
    </div>
</section>
@endsection

@push('scripts')
<script>
    window.addEventListener('load', function () {
        const skeleton = document.getElementById('partnerSkeleton');
        const grid = document.getElementById('partnersGrid');

        if (skeleton && grid) {
            skeleton.classList.add('d-none');
            grid.classList.remove('d-none');
        }
    });
</script>
@endpush
