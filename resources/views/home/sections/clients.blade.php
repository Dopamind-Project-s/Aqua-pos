        <!-- Our Clients Start -->
        <section class="container-fluid clients-section py-5" data-cms-section="clients"> 
            <div class="container py-5"> 
                <div class="section-title mb-5 wow fadeInUp" data-wow-delay="0.1s"> 
                    <div class="sub-style"><h4 class="sub-title px-3 mb-0" data-i18n="clients.eyebrow">Our Clients</h4></div>
                    <h1 class="display-3 mb-3" data-i18n="clients.title">Trusted by Leading Brands</h1>
                    <p class="mb-0" data-i18n="clients.subtitle">We proudly serve ambitious brands across retail and hospitality.</p>
                </div>
                @if(($clients ?? collect())->count())
                <div class="swiper clients-swiper"> 
                    <div class="swiper-wrapper"> 
                        @foreach($clients as $client)
                            <x-client-card :client="$client" />
                        @endforeach
                    </div>
                </div>
                <div class="text-center mt-4">
                    <a href="{{ route('clients.index') }}" class="btn btn-outline-primary rounded-pill px-4 py-2">Show More Clients</a>
                </div>
                @else
                    <p class="text-center text-muted" data-i18n="clients.empty">Clients will be published soon.</p>
                @endif
            </div>
        </section>
        <!-- Our Clients End -->
