        <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->


<!-- Navbar & Hero Start -->
<div class="container-fluid position-relative p-0" data-cms-section="header">
            @php
                $cmsPageKey = str_replace('.', '-', Route::currentRouteName() ?? trim(request()->path(), '/') ?: 'home');
                $logoSrc = dynamic_content($cmsPageKey . '.header.site.logo.src', $siteSetting?->primary_logo ? public_storage_url($siteSetting->primary_logo) : asset('img/LOGO.png'));
                $logoWidth = dynamic_content($cmsPageKey . '.header.style.site.logo.width');
                $logoHeight = dynamic_content($cmsPageKey . '.header.style.site.logo.height');
            @endphp
            <nav class="navbar navbar-expand-lg navbar-light bg-white px-4 px-lg-5 py-3 py-lg-0">
                <a href="{{ url('/') }}" class="navbar-brand p-0">
                    <img src="{{ $logoSrc }}" alt="AQUA POS" class="navbar-brand__logo" data-cms-key="site.logo" @if($logoWidth) style="width: {{ $logoWidth }}; @if($logoHeight) height: {{ $logoHeight }}; @endif" @endif>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="fa fa-bars"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <div class="navbar-nav ms-auto py-0">
                        <a href="{{ route('home') }}" class="nav-item nav-link nav-link--home {{ request()->routeIs('home') ? 'active' : '' }}" aria-label="Home">
                            <i class="{{ dynamic_content($cmsPageKey . '.header.nav.home_icon.value', 'fas fa-home') }}" data-cms-key="nav.home_icon"></i>
                            <span data-i18n="nav.home">Home</span>
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
                                                <h4 class="mega-menu__heading">{{ $menuCategory->localized_name }}</h4>
                                                <button class="mega-menu__category-toggle" type="button" aria-expanded="false">{{ $menuCategory->localized_name }}</button>
                                                <div class="mega-menu__services">
                                                    @foreach($menuCategory->products as $menuProduct)
                                                        <a href="{{ route('products.show', $menuProduct->slug) }}" class="mega-menu__service">
                                                            <img class="mega-menu__service-thumb" src="{{ $menuProduct->image_url }}" alt="{{ $menuProduct->localized_name }}">
                                                            <div class="mega-menu__service-content">
                                                                <h5>{{ $menuProduct->localized_name }}</h5>
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
                        <a href="{{ route('about') }}" class="nav-item nav-link {{ request()->routeIs('about') ? 'active' : '' }}"><i class="fas fa-circle-info me-2"></i><span data-i18n="nav.about">About</span></a>
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
                    <a href="{{ route('admin.login') }}" class="btn btn-outline-primary rounded-pill py-2 px-4 ms-lg-2 flex-wrap flex-sm-shrink-0 {{ request()->routeIs('admin.login') ? 'active' : '' }}"><i class="fas fa-sign-in-alt me-2"></i>Login</a>
                    <a href="{{ route('request-product-demo') }}" class="btn btn-primary rounded-pill text-white py-2 px-4 ms-lg-2 flex-wrap flex-sm-shrink-0"><i class="fas fa-calendar-check me-2"></i>Request Demo</a>
                </div>
            </nav>


            @if($showCarousel ?? false)

            <!-- Carousel Start -->
            <div class="header-carousel owl-carousel" data-cms-section="hero">
                <div class="header-carousel-item" data-cms-section="hero-slide-1">
                    <img src="{{ dynamic_content($cmsPageKey . '.hero.home.hero.image_1.src', asset('img/carousel-1.jpg')) }}" class="img-fluid w-100" alt="Image" data-cms-key="home.hero.image_1">
                    <div class="carousel-caption">
                        <div class="carousel-caption-content p-3">
                            <h5 class="text-white text-uppercase fw-bold mb-4" style="letter-spacing: 3px;" data-cms-key="home.hero.eyebrow">{{ dynamic_content($cmsPageKey . '.hero.home.hero.eyebrow.en', 'Cloud POS Platform') }}</h5>
                            <h1 class="display-1 text-capitalize text-white mb-4" data-cms-key="home.hero.title">{{ dynamic_content($cmsPageKey . '.hero.home.hero.title.en', 'Powerful POS & Inventory Management Software') }}</h1>
                            <p class="mb-5 fs-5" data-cms-key="home.hero.description">{{ dynamic_content($cmsPageKey . '.hero.home.hero.description.en', 'Built in Amman, Jordan, AQUA POS helps restaurants and retailers manage sales, stock, and branches with speed, control, and real-time visibility.') }}
                            </p>
                            <a class="btn btn-primary rounded-pill text-white py-3 px-5" href="{{ dynamic_content($cmsPageKey . '.hero.home.hero.cta.link', '#') }}" data-cms-key="home.hero.cta"><span>{{ dynamic_content($cmsPageKey . '.hero.home.hero.cta.en', 'Book Appointment') }}</span></a>
                        </div>
                    </div>
                </div>
                <div class="header-carousel-item" data-cms-section="hero-slide-2">
                    <img src="{{ dynamic_content($cmsPageKey . '.hero.home.hero.image_2.src', asset('img/carousel-2.jpg')) }}" class="img-fluid w-100" alt="Image" data-cms-key="home.hero.image_2">
                    <div class="carousel-caption">
                        <div class="carousel-caption-content p-3">
                            <h5 class="text-white text-uppercase fw-bold mb-4" style="letter-spacing: 3px;" data-cms-key="home.hero.eyebrow_2">{{ dynamic_content($cmsPageKey . '.hero.home.hero.eyebrow_2.en', 'Cloud POS Platform') }}</h5>
                            <h1 class="display-1 text-capitalize text-white mb-4" data-cms-key="home.hero.title_2">{{ dynamic_content($cmsPageKey . '.hero.home.hero.title_2.en', 'Powerful POS & Inventory Management Software') }}</h1>
                            <p class="mb-5 fs-5 animated slideInDown" data-cms-key="home.hero.description_2">{{ dynamic_content($cmsPageKey . '.hero.home.hero.description_2.en', 'Built in Amman, Jordan, AQUA POS helps restaurants and retailers manage sales, stock, and branches with speed, control, and real-time visibility.') }}
                            </p>
                            <a class="btn btn-primary rounded-pill text-white py-3 px-5" href="{{ dynamic_content($cmsPageKey . '.hero.home.hero.cta_2.link', '#') }}" data-cms-key="home.hero.cta_2"><span>{{ dynamic_content($cmsPageKey . '.hero.home.hero.cta_2.en', 'Book Appointment') }}</span></a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Carousel End -->
            @endif
        </div>
        <!-- Navbar & Hero End -->
