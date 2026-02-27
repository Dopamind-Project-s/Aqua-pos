@props(['partner'])

<article class="partner-card h-100">
    <div class="partner-card__logo-wrap">
        <img
            src="{{ Storage::url($partner->logo) }}"
            alt="{{ $partner->name }} logo"
            class="partner-card__logo"
            loading="lazy"
            decoding="async"
        >
    </div>
    <div class="partner-card__body">
        <h3 class="partner-card__title">{{ $partner->name }}</h3>
        @if($partner->description)
            <p class="partner-card__description">{{ $partner->description }}</p>
        @else
            <p class="partner-card__description" data-i18n="partners.defaultDescription">Trusted partner supporting our ecosystem with reliable services.</p>
        @endif

        @if($partner->website_url)
            <a href="{{ $partner->website_url }}" class="partner-card__link" target="_blank" rel="noopener noreferrer">
                <span data-i18n="partners.visitWebsite">Visit Website</span>
                <i class="fas fa-arrow-up-right-from-square ms-1" aria-hidden="true"></i>
            </a>
        @endif
    </div>
</article>
