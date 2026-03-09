@props(['client'])
<div class="swiper-slide">
    <article class="client-logo-card">
        <img src="{{ Storage::url($client->logo) }}" alt="{{ $client->name }}" class="client-logo-card__img">
        <div class="client-logo-card__overlay">
            <h6>{{ $client->name }}</h6>
            <div class="client-logo-card__links">
                @foreach(['website_url'=>'fas fa-globe','facebook_url'=>'fab fa-facebook-f','instagram_url'=>'fab fa-instagram','linkedin_url'=>'fab fa-linkedin-in','twitter_url'=>'fab fa-twitter','youtube_url'=>'fab fa-youtube'] as $field=>$icon)
                    @if($client->{$field})
                        <a href="{{ $client->{$field} }}" target="_blank" rel="noopener noreferrer"><i class="{{ $icon }}"></i></a>
                    @endif
                @endforeach
            </div>
        </div>
    </article>
</div>
