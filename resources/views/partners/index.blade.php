@extends('layouts.app')

@section('content')
@include('partials.page-hero', [
    'icon' => 'fas fa-handshake',
    'badge' => 'Strategic Ecosystem',
    'badgeI18n' => 'partners.eyebrow',
    'title' => 'Enterprise Partnerships That Scale',
    'titleI18n' => 'partners.title',
    'subtitle' => 'We collaborate with high-impact brands and technology leaders to deliver seamless, scalable, and future-ready solutions.',
    'subtitleI18n' => 'partners.subtitle',
])

<section class="partners-section">
    <div class="container">
        <div class="partners-toolbar d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
            <div>
                <h2 class="partners-toolbar__title mb-1" data-i18n="partners.gridTitle">Our Partner Network</h2>
                <p class="partners-toolbar__subtitle mb-0" data-i18n="partners.gridSubtitle">Select from strategic partners helping clients accelerate digital operations.</p>
            </div>
            <span class="partners-toolbar__count">
                <i class="fas fa-building"></i>
                <span>{{ $partners->total() }}</span>
                <small data-i18n="partners.countLabel">Partners</small>
            </span>
        </div>

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
                <h2 data-i18n="partners.emptyTitle">No partners yet</h2>
                <p data-i18n="partners.emptySubtitle">We are currently onboarding exceptional partners. Please check back soon.</p>
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
