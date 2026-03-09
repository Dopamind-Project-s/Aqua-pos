@props(['partner'])

<article class="partner-card h-100">
    <div class="partner-card__logo-wrap">
        <img src="{{ Storage::url($partner->logo) }}" alt="{{ $partner->name }} logo" class="partner-card__logo" loading="lazy" decoding="async">
    </div>

    <div class="partner-card__overlay">
        <h3 class="partner-card__title">{{ $partner->name }}</h3>
        <div class="partner-card__actions">
            @if($partner->website_url)
                <a href="{{ $partner->website_url }}" target="_blank" rel="noopener noreferrer" aria-label="Website"><i class="fas fa-globe"></i><span data-i18n="partners.website">Website</span></a>
            @endif
            @if($partner->apply_url)
                <a href="{{ $partner->apply_url }}" target="_blank" rel="noopener noreferrer" aria-label="Apply"><i class="fas fa-paper-plane"></i><span data-i18n="partners.apply">Apply</span></a>
            @endif
            @if($partner->facebook_url)
                <a href="{{ $partner->facebook_url }}" target="_blank" rel="noopener noreferrer" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
            @endif
            @if($partner->instagram_url)
                <a href="{{ $partner->instagram_url }}" target="_blank" rel="noopener noreferrer" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
            @endif
            @if($partner->linkedin_url)
                <a href="{{ $partner->linkedin_url }}" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
            @endif
            @if($partner->twitter_url)
                <a href="{{ $partner->twitter_url }}" target="_blank" rel="noopener noreferrer" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
            @endif
            @if($partner->youtube_url)
                <a href="{{ $partner->youtube_url }}" target="_blank" rel="noopener noreferrer" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
            @endif
        </div>
    </div>
</article>
