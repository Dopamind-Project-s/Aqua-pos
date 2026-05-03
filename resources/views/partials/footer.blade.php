<!-- Footer Start -->
<div class="container-fluid footer py-5 wow fadeIn" data-wow-delay="0.2s" data-cms-section="footer">
            <div class="container py-5">
                <div class="row g-3 g-lg-4 mb-4 pb-4 border-bottom border-light border-opacity-25 justify-content-between align-items-center">
                    <div class="col-12 col-xl-8">
                        <div class="d-flex flex-column flex-md-row flex-wrap align-items-start align-items-md-center topbar-contact-list gap-2 gap-md-0">
                            <a href="{{ $siteSetting?->google_map_embed ?: '#' }}" class="text-light me-md-4" target="_blank" rel="noopener">
                                <i class="fas fa-map-marker-alt text-primary me-2"></i>
                                <span>{{ $siteSetting?->hq_address ?: 'Amman, Jordan' }}</span>
                            </a>
                            <a href="tel:{{ preg_replace('/\D+/', '', $siteSetting?->phone_primary ?: '+962791888655') }}" class="text-light me-md-4">
                                <i class="fas fa-phone-alt text-primary me-2"></i>{{ $siteSetting?->phone_primary ?: '+962-791888655' }}
                            </a>
                            <a href="mailto:{{ $siteSetting?->info_email ?: 'info@aqua-pos.com' }}" class="text-light">
                                <i class="fas fa-envelope text-primary me-2"></i>{{ $siteSetting?->info_email ?: 'info@aqua-pos.com' }}
                            </a>
                        </div>
                    </div>
                    <div class="col-12 col-xl-4">
                        <div class="d-flex align-items-center justify-content-xl-end topbar-social-list">
                            @if($siteSetting?->facebook_url)
                                <a href="{{ $siteSetting->facebook_url }}" target="_blank" rel="noopener" class="btn btn-light btn-square border rounded-circle nav-fill topbar-social-btn topbar-social-btn--facebook me-2"><i class="fab fa-facebook-f"></i></a>
                            @endif
                            @if($siteSetting?->twitter_url)
                                <a href="{{ $siteSetting->twitter_url }}" target="_blank" rel="noopener" class="btn btn-light btn-square border rounded-circle nav-fill topbar-social-btn topbar-social-btn--twitter me-2"><i class="fab fa-twitter"></i></a>
                            @endif
                            @if($siteSetting?->instagram_url)
                                <a href="{{ $siteSetting->instagram_url }}" target="_blank" rel="noopener" class="btn btn-light btn-square border rounded-circle nav-fill topbar-social-btn topbar-social-btn--instagram me-2"><i class="fab fa-instagram"></i></a>
                            @endif
                            @if($siteSetting?->linkedin_url)
                                <a href="{{ $siteSetting->linkedin_url }}" target="_blank" rel="noopener" class="btn btn-light btn-square border rounded-circle nav-fill topbar-social-btn topbar-social-btn--linkedin me-2"><i class="fab fa-linkedin-in"></i></a>
                            @endif
                            @if($siteSetting?->youtube_url)
                                <a href="{{ $siteSetting->youtube_url }}" target="_blank" rel="noopener" class="btn btn-light btn-square border rounded-circle nav-fill topbar-social-btn topbar-social-btn--youtube me-2"><i class="fab fa-youtube"></i></a>
                            @endif
                            @if($siteSetting?->tiktok_url)
                                <a href="{{ $siteSetting->tiktok_url }}" target="_blank" rel="noopener" class="btn btn-light btn-square border rounded-circle nav-fill topbar-social-btn topbar-social-btn--tiktok"><i class="fab fa-tiktok"></i></a>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row g-4 g-lg-5">
                    <div class="col-md-6 col-lg-6 col-xl-4">
                        <div class="footer-item footer-item--about d-flex flex-column">
                            <div class="footer-brand mb-3">
                                @if($siteSetting?->secondary_logo)
                                    <img src="{{ public_storage_url($siteSetting->secondary_logo) }}" alt="{{ $siteSetting?->site_name ?: 'AQUA POS' }}" class="footer-logo">
                                @elseif($siteSetting?->primary_logo)
                                    <img src="{{ public_storage_url($siteSetting->primary_logo) }}" alt="{{ $siteSetting?->site_name ?: 'AQUA POS' }}" class="footer-logo">
                                @else
                                    <h4 class="text-white mb-0"><i class="fas fa-star-of-life me-3"></i>{{ $siteSetting?->footer_company_title ?: ($siteSetting?->site_name ?: 'AQUA POS') }}</h4>
                                @endif
                            </div>

                            <p class="footer-about-text mb-3">{{ $siteSetting?->about_site_paragraph ?: ($siteSetting?->footer_company_description ?: 'AQUA POS is a Jordanian SaaS company in Amman delivering reliable POS and inventory software that helps businesses operate with speed and accuracy') }}</p>

                            <div class="d-flex align-items-center footer-socials mt-auto">
                                <i class="fas fa-share-alt text-white me-2"></i>
                                @if($siteSetting?->facebook_url)<a class="btn-square btn btn-primary text-white rounded-circle mx-1" href="{{ $siteSetting->facebook_url }}" target="_blank" rel="noopener" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>@endif
                                @if($siteSetting?->twitter_url)<a class="btn-square btn btn-primary text-white rounded-circle mx-1" href="{{ $siteSetting->twitter_url }}" target="_blank" rel="noopener" aria-label="Twitter"><i class="fab fa-twitter"></i></a>@endif
                                @if($siteSetting?->instagram_url)<a class="btn-square btn btn-primary text-white rounded-circle mx-1" href="{{ $siteSetting->instagram_url }}" target="_blank" rel="noopener" aria-label="Instagram"><i class="fab fa-instagram"></i></a>@endif
                                @if($siteSetting?->linkedin_url)<a class="btn-square btn btn-primary text-white rounded-circle mx-1" href="{{ $siteSetting->linkedin_url }}" target="_blank" rel="noopener" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>@endif
                                @if($siteSetting?->youtube_url)<a class="btn-square btn btn-primary text-white rounded-circle mx-1" href="{{ $siteSetting->youtube_url }}" target="_blank" rel="noopener" aria-label="YouTube"><i class="fab fa-youtube"></i></a>@endif
                                @if($siteSetting?->tiktok_url)<a class="btn-square btn btn-primary text-white rounded-circle mx-1" href="{{ $siteSetting->tiktok_url }}" target="_blank" rel="noopener" aria-label="TikTok"><i class="fab fa-tiktok"></i></a>@endif
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-6 col-xl-2">
                        <div class="footer-item d-flex flex-column">
                            <h4 class="mb-4 text-white" data-i18n="footer.quickLinks">Quick Links</h4>
                            <a href="{{ route('about') }}"><i class="fas fa-angle-right me-2"></i><span data-i18n="footer.about">About Us</span></a>
                            <a href="{{ route('contact') }}"><i class="fas fa-angle-right me-2"></i><span data-i18n="footer.contact">Contact Us</span></a>
                            <a href="{{ route('blog') }}"><i class="fas fa-angle-right me-2"></i><span data-i18n="footer.blog">Our Blog & News</span></a>
                            <a href="{{ route('partners.index') }}"><i class="fas fa-angle-right me-2"></i><span data-i18n="footer.partners">Partners</span></a>
                            <a href="{{ route('products') }}"><i class="fas fa-angle-right me-2"></i><span data-i18n="footer.products">Products</span></a>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-6 col-xl-3">
                        <div class="footer-item d-flex flex-column">
                            <h4 class="mb-4 text-white" data-i18n="footer.servicesTitle">AQUA POS Services</h4>
                            <a href="{{ route('products') }}"><i class="fas fa-angle-right me-2"></i><span data-i18n="footer.service1">POS & Inventory Platform</span></a>
                            <a href="{{ route('products') }}"><i class="fas fa-angle-right me-2"></i><span data-i18n="footer.service2">Smart Inventory Control</span></a>
                            <a href="{{ route('products') }}"><i class="fas fa-angle-right me-2"></i><span data-i18n="footer.service3">Real-Time Analytics</span></a>
                            <a href="{{ route('products') }}"><i class="fas fa-angle-right me-2"></i><span data-i18n="footer.service4">Multi-Branch Management</span></a>
                            <a href="{{ route('products') }}"><i class="fas fa-angle-right me-2"></i><span data-i18n="footer.service5">Restaurant POS</span></a>
                            <a href="{{ route('products') }}"><i class="fas fa-angle-right me-2"></i><span data-i18n="footer.service6">Retail POS</span></a>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-6 col-xl-3">
                        <div class="footer-item footer-contact d-flex flex-column">
                            <h4 class="mb-4 text-white">{{ $siteSetting?->hq_title ?: 'Head Quarter' }}</h4>
                            <a href="{{ $siteSetting?->google_map_embed ?: '#' }}" target="_blank" rel="noopener"><i class="fa fa-map-marker-alt me-2"></i> {{ $siteSetting?->hq_address ?: 'AQUA POS Amman, Jordan' }}</a>
                            <a href="mailto:{{ $siteSetting?->info_email ?: 'info@aqua-pos.com' }}"><i class="fas fa-envelope me-2"></i> {{ $siteSetting?->info_email ?: 'info@aqua-pos.com' }}</a>
                            <a href="mailto:{{ $siteSetting?->support_email ?: 'support@aqua-pos.com' }}"><i class="fas fa-envelope me-2"></i> {{ $siteSetting?->support_email ?: 'support@aqua-pos.com' }}</a>
                            <a href="tel:{{ preg_replace('/\s+/', '', $siteSetting?->phone_primary ?: '+962 79 1888655') }}"><i class="fas fa-phone me-2"></i> {{ $siteSetting?->phone_primary ?: '+962 79 1888655' }}</a>
                            <a href="tel:{{ preg_replace('/\s+/', '', $siteSetting?->phone_secondary ?: '+962-791888655') }}" class="mb-2"><i class="fas fa-print me-2"></i> {{ $siteSetting?->phone_secondary ?: '+962-791888655' }}</a>
                            <a href="https://wa.me/{{ preg_replace('/\D+/', '', $siteSetting?->whatsapp_number ?: '+962791888655') }}" target="_blank" rel="noopener"><i class="fab fa-whatsapp me-2"></i> {{ $siteSetting?->whatsapp_number ?: '+962791888655' }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer End -->

        <!-- Back to Top -->
        <a href="#" class="btn btn-primary btn-lg-square back-to-top"><i class="fa fa-arrow-up"></i></a>
