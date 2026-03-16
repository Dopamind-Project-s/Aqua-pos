        <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->


        <!-- Topbar Start -->
        <div class="container-fluid topbar-shell px-5 d-none d-lg-block">
            <div class="row gx-0 align-items-center" style="min-height: 52px;">
                <div class="col-lg-8 text-center text-lg-start mb-lg-0">
                    <div class="d-flex flex-wrap align-items-center topbar-contact-list">
                        <a href="{{ $siteSetting?->google_map_embed ?: '#' }}" class="text-light me-4" target="_blank" rel="noopener">
                            <i class="fas fa-map-marker-alt text-primary me-2"></i>
                            <span>{{ $siteSetting?->hq_address ?: 'Amman, Jordan' }}</span>
                        </a>
                        <a href="tel:{{ preg_replace('/\D+/', '', $siteSetting?->phone_primary ?: '+962791888655') }}" class="text-light me-4">
                            <i class="fas fa-phone-alt text-primary me-2"></i>{{ $siteSetting?->phone_primary ?: '+962-791888655' }}
                        </a>
                        <a href="mailto:{{ $siteSetting?->info_email ?: 'info@aqua-pos.com' }}" class="text-light me-0">
                            <i class="fas fa-envelope text-primary me-2"></i>{{ $siteSetting?->info_email ?: 'info@aqua-pos.com' }}
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 text-center text-lg-end">
                    <div class="d-flex align-items-center justify-content-end topbar-social-list">
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
        </div>
        <!-- Topbar End -->


        <!-- Navbar & Hero Start -->
        <div class="container-fluid position-relative p-0">
            <nav class="navbar navbar-expand-lg navbar-light bg-white px-4 px-lg-5 py-3 py-lg-0">
                <a href="{{ url('/') }}" class="navbar-brand p-0">
                    @if($siteSetting?->primary_logo)
                        <img src="{{ Storage::url($siteSetting->primary_logo) }}" alt="{{ $siteSetting?->site_name ?: 'AQUA POS' }}" class="navbar-brand__logo">
                    @else
                        <h1 class="navbar-brand__title text-primary m-0"><i class="fas fa-star-of-life me-2"></i>{{ $siteSetting?->site_name ?: 'AQUA POS' }}</h1>
                    @endif
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="fa fa-bars"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <div class="navbar-nav ms-auto py-0">
                        <a href="{{ route('home') }}" class="nav-item nav-link nav-link--home {{ request()->routeIs('home') ? 'active' : '' }}" aria-label="Home">
                            <i class="fas fa-home"></i>
                        </a>
                        <div class="nav-item mega-menu" id="productsMegaMenu">
                            <button
                                class="nav-link mega-menu__trigger"
                                type="button"
                                aria-expanded="false"
                                aria-controls="productsMegaPanel"
                            >
                                <i class="fas fa-box-open me-2"></i><span data-i18n="nav.products">Products</span>
                                <span class="mega-menu__caret" aria-hidden="true">▾</span>
                            </button>

                            <section class="mega-menu__panel" id="productsMegaPanel" aria-label="Products Mega Menu">
                                <div class="mega-menu__inner">
                                    <div class="mega-menu__grid">
                                        @forelse($activeCategoriesMenu ?? collect() as $menuCategory)
                                            <article class="mega-menu__category">
                                                <h4 class="mega-menu__heading">{{ $menuCategory->name_en ?: $menuCategory->name }}<small class="d-block text-muted">{{ $menuCategory->name_ar }}</small></h4>
                                                <button class="mega-menu__category-toggle" type="button" aria-expanded="false">{{ $menuCategory->name_en ?: $menuCategory->name }} / {{ $menuCategory->name_ar }}</button>
                                                <div class="mega-menu__services">
                                                    @foreach($menuCategory->products->take(6) as $menuProduct)
                                                        <a href="{{ route('products.show', $menuProduct->slug) }}" class="mega-menu__service">
                                                            <img class="mega-menu__service-thumb" src="{{ $menuProduct->image ? Storage::url($menuProduct->image) : asset('img/service-1.jpg') }}" alt="{{ $menuProduct->localized_name }}">
                                                            <div class="mega-menu__service-content">
                                                                <h5>{{ $menuProduct->name_en ?: $menuProduct->name }}<small class="d-block text-muted">{{ $menuProduct->name_ar }}</small></h5>
                                                                <p>{{ $menuProduct->localized_short_description }}</p>
                                                                
                                                            </div>
                                                        </a>
                                                    @endforeach
                                                </div>
                                            </article>
                                        @empty
                                            <article class="mega-menu__category">
                                                <h4 class="mega-menu__heading">Products</h4>
                                                <div class="mega-menu__services">
                                                    <a href="{{ route('products') }}" class="mega-menu__service">
                                                        <img class="mega-menu__service-thumb" src="{{ asset('img/service-1.jpg') }}" alt="Products">
                                                        <div class="mega-menu__service-content"><h5>No active products yet</h5></div>
                                                    </a>
                                                </div>
                                            </article>
                                        @endforelse
                                    </div>
                                </div>
                            </section>
                        </div>

                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle {{ request()->routeIs('blog*') || request()->routeIs('news*') ? 'active' : '' }}" data-bs-toggle="dropdown">
                                <i class="fas fa-newspaper me-2"></i><span data-i18n="nav.insights">Insights</span>
                            </a>
                            <div class="dropdown-menu m-0">
                                <a href="{{ route('blog') }}" class="dropdown-item {{ request()->routeIs('blog*') ? 'active' : '' }}"><i class="fas fa-blog me-2"></i><span data-i18n="nav.blog">Blog</span></a>
                                <a href="{{ route('news') }}" class="dropdown-item {{ request()->routeIs('news*') ? 'active' : '' }}"><i class="fas fa-rss me-2"></i><span data-i18n="nav.news">News</span></a>
                            </div>
                        </div>
                        <a href="{{ route('partners.index') }}" class="nav-item nav-link {{ request()->routeIs('partners.*') ? 'active' : '' }} nav-link--partners"><i class="fas fa-handshake me-2"></i><span data-i18n="nav.partners">Partners</span></a>
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle {{ request()->routeIs('support') || request()->routeIs('contact') ? 'active' : '' }}" data-bs-toggle="dropdown">
                                <i class="fas fa-headset me-2"></i><span data-i18n="nav.help">Help</span>
                            </a>
                            <div class="dropdown-menu m-0">
                                <a href="{{ route('support') }}" class="dropdown-item {{ request()->routeIs('support') ? 'active' : '' }}"><i class="fas fa-life-ring me-2"></i><span data-i18n="nav.support">Support</span></a>
                                <a href="{{ route('contact') }}" class="dropdown-item {{ request()->routeIs('contact') ? 'active' : '' }}"><i class="fas fa-envelope me-2"></i><span data-i18n="nav.contact">Contact</span></a>
                            </div>
                        </div>
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle {{ request()->routeIs('about') || request()->routeIs('service') ? 'active' : '' }}" data-bs-toggle="dropdown"><i class="fas fa-layer-group me-2"></i><span data-i18n="nav.pages">Pages</span></a>
                            <div class="dropdown-menu m-0">
                                <a href="{{ route('about') }}" class="dropdown-item {{ request()->routeIs('about') ? 'active' : '' }}"><i class="fas fa-circle-info me-2"></i><span data-i18n="nav.about">About</span></a>
                                <a href="{{ route('service') }}" class="dropdown-item {{ request()->routeIs('service') ? 'active' : '' }}"><i class="fas fa-concierge-bell me-2"></i><span data-i18n="nav.services">Services</span></a>
                                <a href="{{ route('appointment') }}" class="dropdown-item"><i class="fas fa-calendar-days me-2"></i><span data-i18n="nav.appointment">Appointment</span></a>
                                <a href="{{ route('feature') }}" class="dropdown-item"><i class="fas fa-star me-2"></i><span data-i18n="nav.features">Features</span></a>
                                <a href="{{ route('clients.index') }}" class="dropdown-item {{ request()->routeIs('clients.*') ? 'active' : '' }}"><i class="fas fa-users me-2"></i><span data-i18n="nav.clients">Our Clients</span></a>
                                <a href="{{ route('testimonial') }}" class="dropdown-item"><i class="fas fa-comments me-2"></i><span data-i18n="nav.testimonial">Testimonial</span></a>
                            </div>
                        </div>
                    </div>
                    <div class="nav-toolbar" aria-label="Quick controls">
                        <button class="nav-toolbar__btn nav-toolbar__btn--toggle" id="themeToggle" type="button" aria-label="Toggle theme">
                            <span class="nav-toggle-pill" data-theme-option="light"><i class="fas fa-sun"></i></span>
                            <span class="nav-toggle-pill" data-theme-option="dark"><i class="fas fa-moon"></i></span>
                            <span class="visually-hidden" id="themeLabel" data-i18n="controls.dark">Dark</span>
                        </button>
                        <button class="nav-toolbar__btn nav-toolbar__btn--toggle" id="languageToggle" type="button" aria-label="Toggle language">
                            <span class="nav-toggle-pill" data-lang-option="ar">عر</span>
                            <span class="nav-toggle-pill" data-lang-option="en">EN</span>
                            <span class="visually-hidden" id="languageLabel">AR / EN</span>
                        </button>
                    </div>
                    <a href="{{ route('request-product-demo') }}" class="btn btn-primary rounded-pill text-white py-2 px-4 flex-wrap flex-sm-shrink-0"><i class="fas fa-calendar-check me-2"></i>Request Demo</a>
                </div>
            </nav>


            @if($showCarousel ?? false)

            <!-- Carousel Start -->
            <div class="header-carousel owl-carousel">
                <div class="header-carousel-item">
                    <img src="{{ asset('img/carousel-1.jpg') }}" class="img-fluid w-100" alt="Image">
                    <div class="carousel-caption">
                        <div class="carousel-caption-content p-3">
                            <h5 class="text-white text-uppercase fw-bold mb-4" style="letter-spacing: 3px;">Cloud POS Platform</h5>
                            <h1 class="display-1 text-capitalize text-white mb-4">Powerful POS & Inventory Management Software</h1>
                            <p class="mb-5 fs-5">Built in Amman, Jordan, AQUA POS helps restaurants and retailers manage sales, stock, and branches with speed, control, and real-time visibility. 
                            </p>
                            <a class="btn btn-primary rounded-pill text-white py-3 px-5" href="#"><span data-i18n="nav.book">Book Appointment</span></a>
                        </div>
                    </div>
                </div>
                <div class="header-carousel-item">
                    <img src="{{ asset('img/carousel-2.jpg') }}" class="img-fluid w-100" alt="Image">
                    <div class="carousel-caption">
                        <div class="carousel-caption-content p-3">
                            <h5 class="text-white text-uppercase fw-bold mb-4" style="letter-spacing: 3px;">Cloud POS Platform</h5>
                            <h1 class="display-1 text-capitalize text-white mb-4">Powerful POS & Inventory Management Software</h1>
                            <p class="mb-5 fs-5 animated slideInDown">Built in Amman, Jordan, AQUA POS helps restaurants and retailers manage sales, stock, and branches with speed, control, and real-time visibility. 
                            </p>
                            <a class="btn btn-primary rounded-pill text-white py-3 px-5" href="#"><span data-i18n="nav.book">Book Appointment</span></a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Carousel End -->
            @endif
        </div>
        <!-- Navbar & Hero End -->
