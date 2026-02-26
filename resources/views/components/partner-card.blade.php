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
        <p class="partner-card__description">{{ $partner->description ?: 'Trusted partner supporting our ecosystem with reliable services.' }}</p>

        @if($partner->website_url)
            <a href="{{ $partner->website_url }}" class="partner-card__link" target="_blank" rel="noopener noreferrer">
                Visit Website <i class="fas fa-external-link-alt ms-1" aria-hidden="true"></i>
            </a>
        @endif
    </div>
</article>
