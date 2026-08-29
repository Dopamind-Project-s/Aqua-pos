<!-- Footer Start -->
<div class="container-fluid footer py-5 wow fadeIn" dir="{{ app_text_direction() }}" data-wow-delay="0.2s" data-cms-section="footer">
            @php
                $footerLogo = $siteSetting?->secondary_logo
                    ? public_storage_url($siteSetting->secondary_logo)
                    : ($siteSetting?->primary_logo ? public_storage_url($siteSetting->primary_logo) : null);

                $footerCompanyTitle = $siteSetting?->footer_company_title ?: ($siteSetting?->site_name ?: 'AQUA POS');
                $footerAboutText = $siteSetting?->about_site_paragraph ?: ($siteSetting?->footer_company_description ?: 'AQUA POS is a Jordanian SaaS company in Amman delivering reliable POS and inventory software that helps businesses operate with speed and accuracy');
                $footerAddress = $siteSetting?->hq_address ?: 'AQUA POS Amman, Jordan';
                $footerInfoEmail = $siteSetting?->info_email ?: 'info@aqua-pos.com';
                $footerSupportEmail = $siteSetting?->support_email ?: 'support@aqua-pos.com';
                $footerPrimaryPhone = $siteSetting?->phone_primary ?: '+962 79 1888655';
                $footerSecondaryPhone = $siteSetting?->phone_secondary ?: '+962-791888655';
                $footerWhatsapp = $siteSetting?->whatsapp_number ?: '+962791888655';
                $footerLocale = app()->getLocale();
            @endphp
            <div class="container py-5">
                <div class="row g-3 g-lg-4 mb-4 pb-4 border-bottom border-light border-opacity-25 justify-content-between align-items-center">
                    <div class="col-12 col-xl-8">
                        <div class="d-flex flex-column flex-md-row flex-wrap align-items-start align-items-md-center topbar-contact-list gap-2 gap-md-0">
                            <a href="{{ $siteSetting?->google_map_embed ?: '#' }}" class="text-light me-md-4" target="_blank" rel="noopener">
                                <i class="fas fa-map-marker-alt text-primary me-2"></i>
                                <span data-cms-key="topbar.address">{{ dynamic_content("global.footer.topbar.address.{$footerLocale}", $siteSetting?->hq_address ?: 'Amman, Jordan') }}</span>
                            </a>
                            <a href="tel:{{ preg_replace('/\D+/', '', $footerPrimaryPhone) }}" class="text-light me-md-4">
                                <i class="fas fa-phone-alt text-primary me-2"></i><span class="footer-ltr-value" dir="ltr" data-cms-key="topbar.phone">{{ dynamic_content("global.footer.topbar.phone.{$footerLocale}", $footerPrimaryPhone) }}</span>
                            </a>
                            <a href="mailto:{{ $footerInfoEmail }}" class="text-light">
                                <i class="fas fa-envelope text-primary me-2"></i><span class="footer-ltr-value" dir="ltr" data-cms-key="topbar.email">{{ dynamic_content("global.footer.topbar.email.{$footerLocale}", $footerInfoEmail) }}</span>
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
                    <div class="col-md-6 col-xl-4">
                        <div class="footer-item footer-item--about d-flex flex-column">
                            <div class="footer-brand mb-3">
                                @if($footerLogo)
                                    <img src="{{ dynamic_content('global.footer.brand.logo.src', $footerLogo) }}" alt="{{ $siteSetting?->site_name ?: 'AQUA POS' }}" class="footer-logo" data-cms-key="brand.logo" data-cms-type="image">
                                @else
                                    <h4 class="text-white mb-0"><i class="fas fa-star-of-life me-3" data-cms-key="brand.icon" data-cms-type="icon"></i><span data-cms-key="brand.title">{{ dynamic_content("global.footer.brand.title.{$footerLocale}", $footerCompanyTitle) }}</span></h4>
                                @endif
                            </div>

                            <p class="footer-about-text mb-3" data-cms-key="brand.description">{{ dynamic_content("global.footer.brand.description.{$footerLocale}", $footerAboutText) }}</p>

                            <div class="d-flex align-items-center footer-socials mt-auto">
                                <i class="fas fa-share-alt text-white me-2" data-cms-key="social.share_icon" data-cms-type="icon"></i>
                                @if($siteSetting?->facebook_url)<a class="btn btn-light btn-square border rounded-circle nav-fill topbar-social-btn topbar-social-btn--facebook mx-1" href="{{ $siteSetting->facebook_url }}" target="_blank" rel="noopener" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>@endif
                                @if($siteSetting?->twitter_url)<a class="btn btn-light btn-square border rounded-circle nav-fill topbar-social-btn topbar-social-btn--twitter mx-1" href="{{ $siteSetting->twitter_url }}" target="_blank" rel="noopener" aria-label="Twitter"><i class="fab fa-twitter"></i></a>@endif
                                @if($siteSetting?->instagram_url)<a class="btn btn-light btn-square border rounded-circle nav-fill topbar-social-btn topbar-social-btn--instagram mx-1" href="{{ $siteSetting->instagram_url }}" target="_blank" rel="noopener" aria-label="Instagram"><i class="fab fa-instagram"></i></a>@endif
                                @if($siteSetting?->linkedin_url)<a class="btn btn-light btn-square border rounded-circle nav-fill topbar-social-btn topbar-social-btn--linkedin mx-1" href="{{ $siteSetting->linkedin_url }}" target="_blank" rel="noopener" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>@endif
                                @if($siteSetting?->youtube_url)<a class="btn btn-light btn-square border rounded-circle nav-fill topbar-social-btn topbar-social-btn--youtube mx-1" href="{{ $siteSetting->youtube_url }}" target="_blank" rel="noopener" aria-label="YouTube"><i class="fab fa-youtube"></i></a>@endif
                                @if($siteSetting?->tiktok_url)<a class="btn btn-light btn-square border rounded-circle nav-fill topbar-social-btn topbar-social-btn--tiktok mx-1" href="{{ $siteSetting->tiktok_url }}" target="_blank" rel="noopener" aria-label="TikTok"><i class="fab fa-tiktok"></i></a>@endif
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-xl-4">
                        <div class="footer-item d-flex flex-column">
                            <h4 class="mb-4 text-white" data-i18n="footer.servicesTitle" data-cms-key="services.title">{{ dynamic_content("global.footer.services.title.{$footerLocale}", 'AQUA POS Services') }}</h4>
                            <a href="{{ route('products') }}"><i class="fas fa-angle-right me-2" data-cms-key="services.icon" data-cms-type="icon"></i><span data-i18n="footer.service1" data-cms-key="services.item1">{{ dynamic_content("global.footer.services.item1.{$footerLocale}", 'POS & Inventory Platform') }}</span></a>
                            <a href="{{ route('products') }}"><i class="fas fa-angle-right me-2"></i><span data-i18n="footer.service2" data-cms-key="services.item2">{{ dynamic_content("global.footer.services.item2.{$footerLocale}", 'Smart Inventory Control') }}</span></a>
                            <a href="{{ route('products') }}"><i class="fas fa-angle-right me-2"></i><span data-i18n="footer.service3" data-cms-key="services.item3">{{ dynamic_content("global.footer.services.item3.{$footerLocale}", 'Real-Time Analytics') }}</span></a>
                            <a href="{{ route('products') }}"><i class="fas fa-angle-right me-2"></i><span data-i18n="footer.service4" data-cms-key="services.item4">{{ dynamic_content("global.footer.services.item4.{$footerLocale}", 'Multi-Branch Management') }}</span></a>
                            <a href="{{ route('products') }}"><i class="fas fa-angle-right me-2"></i><span data-i18n="footer.service5" data-cms-key="services.item5">{{ dynamic_content("global.footer.services.item5.{$footerLocale}", 'Restaurant POS') }}</span></a>
                            <a href="{{ route('products') }}"><i class="fas fa-angle-right me-2"></i><span data-i18n="footer.service6" data-cms-key="services.item6">{{ dynamic_content("global.footer.services.item6.{$footerLocale}", 'Retail POS') }}</span></a>
                        </div>
                    </div>

                    <div class="col-md-6 col-xl-4">
                        <div class="footer-item footer-contact d-flex flex-column">
                            <h4 class="mb-4 text-white" data-cms-key="contact.title">{{ dynamic_content("global.footer.contact.title.{$footerLocale}", $siteSetting?->hq_title ?: 'Head Quarter') }}</h4>
                            <a href="{{ $siteSetting?->google_map_embed ?: '#' }}" target="_blank" rel="noopener"><i class="fa fa-map-marker-alt me-2"></i><span data-cms-key="contact.address">{{ dynamic_content("global.footer.contact.address.{$footerLocale}", $footerAddress) }}</span></a>
                            <a href="mailto:{{ $footerInfoEmail }}"><i class="fas fa-envelope me-2"></i><span class="footer-ltr-value" dir="ltr" data-cms-key="contact.info_email">{{ dynamic_content("global.footer.contact.info_email.{$footerLocale}", $footerInfoEmail) }}</span></a>
                            <a href="mailto:{{ $footerSupportEmail }}"><i class="fas fa-envelope me-2"></i><span class="footer-ltr-value" dir="ltr" data-cms-key="contact.support_email">{{ dynamic_content("global.footer.contact.support_email.{$footerLocale}", $footerSupportEmail) }}</span></a>
                            <a href="tel:{{ preg_replace('/\s+/', '', $footerPrimaryPhone) }}"><i class="fas fa-phone me-2"></i><span class="footer-ltr-value" dir="ltr" data-cms-key="contact.phone_primary">{{ dynamic_content("global.footer.contact.phone_primary.{$footerLocale}", $footerPrimaryPhone) }}</span></a>
                            <a href="tel:{{ preg_replace('/\s+/', '', $footerSecondaryPhone) }}"><i class="fas fa-print me-2"></i><span class="footer-ltr-value" dir="ltr" data-cms-key="contact.phone_secondary">{{ dynamic_content("global.footer.contact.phone_secondary.{$footerLocale}", $footerSecondaryPhone) }}</span></a>
                            <a href="https://wa.me/{{ preg_replace('/\D+/', '', $footerWhatsapp) }}" target="_blank" rel="noopener"><i class="fab fa-whatsapp me-2"></i><span class="footer-ltr-value" dir="ltr" data-cms-key="contact.whatsapp">{{ dynamic_content("global.footer.contact.whatsapp.{$footerLocale}", $footerWhatsapp) }}</span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer End -->

        <!-- Back to Top -->
        <a href="#" class="btn btn-primary btn-lg-square back-to-top"><i class="fa fa-arrow-up"></i></a>
