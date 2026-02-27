        <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->


        <!-- Topbar Start -->
        <div class="container-fluid topbar-shell px-5 d-none d-lg-block">
            <div class="row gx-0 align-items-center" style="height: 45px;">
                <div class="col-lg-8 text-center text-lg-start mb-lg-0">
                    <div class="d-flex flex-wrap">
                        <a href="#" class="text-light me-4"><i class="fas fa-map-marker-alt text-primary me-2"></i><span data-i18n="topbar.location">Amman, Jordan</span></a>
                        <a href="#" class="text-light me-4"><i class="fas fa-phone-alt text-primary me-2"></i>+962-791888655</a>
                        <a href="#" class="text-light me-0"><i class="fas fa-envelope text-primary me-2"></i>info@aqua-pos.com</a>
                    </div>
                </div>
                <div class="col-lg-4 text-center text-lg-end">
                    <div class="d-flex align-items-center justify-content-end">
                        <a href="https://www.facebook.com/aqua.software.co/" target="_blank" rel="noopener" class="btn btn-light btn-square border rounded-circle nav-fill me-3"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="btn btn-light btn-square border rounded-circle nav-fill me-3"><i class="fab fa-twitter"></i></a>
                        <a href="https://www.instagram.com/aqua_software/?igsh=MWwzOGM2cDliY3Zydw%3D%3D" target="_blank" rel="noopener" class="btn btn-light btn-square border rounded-circle nav-fill me-3"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="btn btn-light btn-square border rounded-circle nav-fill me-0"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Topbar End -->


        <!-- Navbar & Hero Start -->
        <div class="container-fluid position-relative p-0">
            <nav class="navbar navbar-expand-lg navbar-light bg-white px-4 px-lg-5 py-3 py-lg-0">
                <a href="{{ url('/') }}" class="navbar-brand p-0">
                    <h1 class="navbar-brand__title text-primary m-0"><i class="fas fa-star-of-life me-2"></i>AQUA POS</h1>
                    <!-- <img src="img/logo.png" alt="Logo"> -->
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                    <span class="fa fa-bars"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <div class="navbar-nav ms-auto py-0">
                        <a href="{{ route('home') }}" class="nav-item nav-link nav-link--home {{ request()->routeIs('home') ? 'active' : '' }}" aria-label="Home">
                            <i class="fas fa-house"></i>
                            <span class="visually-hidden" data-i18n="nav.home">Home</span>
                        </a>
                        <a href="{{ route('about') }}" class="nav-item nav-link {{ request()->routeIs('about') ? 'active' : '' }}"><i class="fas fa-circle-info me-2"></i><span data-i18n="nav.about">About</span></a>
                        <a href="{{ route('service') }}" class="nav-item nav-link {{ request()->routeIs('service') ? 'active' : '' }}"><i class="fas fa-concierge-bell me-2"></i><span data-i18n="nav.services">Services</span></a>
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
                                                <h4 class="mega-menu__heading">{{ $menuCategory->name }}</h4>
                                                <button class="mega-menu__category-toggle" type="button" aria-expanded="false">{{ $menuCategory->name }}</button>
                                                <div class="mega-menu__services">
                                                    @foreach($menuCategory->products->take(6) as $menuProduct)
                                                        <a href="{{ route('products') }}" class="mega-menu__service">
                                                            <img class="mega-menu__service-thumb" src="{{ $menuProduct->image ? Storage::url($menuProduct->image) : asset('img/service-1.jpg') }}" alt="{{ $menuProduct->name }}">
                                                            <div class="mega-menu__service-content">
                                                                <h5>{{ $menuProduct->name }}</h5>
                                                                
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

                                        <article class="mega-menu__category">
                                            <h4 class="mega-menu__heading"><span data-i18n="mega.restaurant">Restaurant</span></h4>
                                            <button class="mega-menu__category-toggle" type="button" aria-expanded="false"><span data-i18n="mega.restaurant">Restaurant</span></button>
                                            <div class="mega-menu__services">
                                                <a href="#" class="mega-menu__service">
                                                    <img src="{{ asset('img/service-1.jpg') }}" alt="Restaurant POS">
                                                    <div class="mega-menu__service-content">
                                                        <h5><span data-i18n="mega.restaurantPos">Restaurant POS</span></h5>
                                                        
                                                    </div>
                                                </a>
                                                <a href="#" class="mega-menu__service">
                                                    <img src="{{ asset('img/service-2.jpg') }}" alt="QR Ordering">
                                                    <div class="mega-menu__service-content">
                                                        <h5><span data-i18n="mega.qrOrdering">QR Ordering</span></h5>
                                                        
                                                    </div>
                                                </a>
                                            </div>
                                        </article>

                                        <article class="mega-menu__category">
                                            <h4 class="mega-menu__heading"><span data-i18n="mega.retail">Retail</span></h4>
                                            <button class="mega-menu__category-toggle" type="button" aria-expanded="false"><span data-i18n="mega.retail">Retail</span></button>
                                            <div class="mega-menu__services">
                                                <a href="#" class="mega-menu__service">
                                                    <img src="{{ asset('img/service-3.jpg') }}" alt="Inventory Hub">
                                                    <div class="mega-menu__service-content">
                                                        <h5><span data-i18n="mega.inventoryHub">Inventory Hub</span></h5>
                                                        
                                                    </div>
                                                </a>
                                                <a href="#" class="mega-menu__service">
                                                    <img src="{{ asset('img/service-4.jpg') }}" alt="Loyalty CRM">
                                                    <div class="mega-menu__service-content">
                                                        <h5><span data-i18n="mega.loyaltyCrm">Loyalty CRM</span></h5>
                                                        
                                                    </div>
                                                </a>
                                            </div>
                                        </article>

                                        <article class="mega-menu__category">
                                            <h4 class="mega-menu__heading"><span data-i18n="mega.hotel">Hotel</span></h4>
                                            <button class="mega-menu__category-toggle" type="button" aria-expanded="false"><span data-i18n="mega.hotel">Hotel</span></button>
                                            <div class="mega-menu__services">
                                                <a href="#" class="mega-menu__service">
                                                    <img src="{{ asset('img/service-5.jpg') }}" alt="Property PMS">
                                                    <div class="mega-menu__service-content">
                                                        <h5><span data-i18n="mega.propertyPms">Property PMS</span></h5>
                                                        
                                                    </div>
                                                </a>
                                                <a href="#" class="mega-menu__service">
                                                    <img src="{{ asset('img/service-6.jpg') }}" alt="Spa & Wellness">
                                                    <div class="mega-menu__service-content">
                                                        <h5><span data-i18n="mega.spaWellness">Spa & Wellness</span></h5>
                                                        
                                                    </div>
                                                </a>
                                            </div>
                                        </article>

                                        <article class="mega-menu__category">
                                            <h4 class="mega-menu__heading"><span data-i18n="mega.enterprise">Enterprise</span></h4>
                                            <button class="mega-menu__category-toggle" type="button" aria-expanded="false"><span data-i18n="mega.enterprise">Enterprise</span></button>
                                            <div class="mega-menu__services">
                                                <a href="#" class="mega-menu__service">
                                                    <img src="{{ asset('img/service-7.jpg') }}" alt="BI Analytics">
                                                    <div class="mega-menu__service-content">
                                                        <h5><span data-i18n="mega.biAnalytics">BI Analytics</span></h5>
                                                        
                                                    </div>
                                                </a>
                                                <a href="#" class="mega-menu__service">
                                                    <img src="{{ asset('img/service-8.jpg') }}" alt="API Integrations">
                                                    <div class="mega-menu__service-content">
                                                        <h5><span data-i18n="mega.apiIntegrations">API Integrations</span></h5>
                                                        
                                                    </div>
                                                </a>
                                            </div>
                                        </article>
                                    </div>
                                </div>
                            </section>
                        </div>

                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle {{ request()->routeIs('blog*') || request()->routeIs('news*') ? 'active' : '' }}" data-bs-toggle="dropdown">
                                <i class="fas fa-newspaper me-2"></i>Insights
                            </a>
                            <div class="dropdown-menu m-0">
                                <a href="{{ route('blog') }}" class="dropdown-item {{ request()->routeIs('blog*') ? 'active' : '' }}"><i class="fas fa-blog me-2"></i>Blog</a>
                                <a href="{{ route('news') }}" class="dropdown-item {{ request()->routeIs('news*') ? 'active' : '' }}"><i class="fas fa-rss me-2"></i>News</a>
                            </div>
                        </div>
                        <a href="{{ route('partners.index') }}" class="nav-item nav-link {{ request()->routeIs('partners.*') ? 'active' : '' }} nav-link--partners"><i class="fas fa-handshake me-2"></i>Partners</a>
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle {{ request()->routeIs('support') || request()->routeIs('contact') ? 'active' : '' }}" data-bs-toggle="dropdown">
                                <i class="fas fa-headset me-2"></i>Help
                            </a>
                            <div class="dropdown-menu m-0">
                                <a href="{{ route('support') }}" class="dropdown-item {{ request()->routeIs('support') ? 'active' : '' }}"><i class="fas fa-life-ring me-2"></i>Support</a>
                                <a href="{{ route('contact') }}" class="dropdown-item {{ request()->routeIs('contact') ? 'active' : '' }}"><i class="fas fa-envelope me-2"></i>Contact</a>
                            </div>
                        </div>
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i class="fas fa-layer-group me-2"></i><span data-i18n="nav.pages">Pages</span></a>
                            <div class="dropdown-menu m-0">
                                <a href="{{ url('/appointment') }}" class="dropdown-item"><i class="fas fa-calendar-days me-2"></i><span data-i18n="nav.appointment">Appointment</span></a>
                                <a href="{{ url('/feature') }}" class="dropdown-item"><i class="fas fa-star me-2"></i><span data-i18n="nav.features">Features</span></a>
                                <a href="{{ route('request-product-demo') }}" class="dropdown-item"><i class="fas fa-display me-2"></i>Request Product Demo</a>
                                <a href="{{ url('/team') }}" class="dropdown-item"><i class="fas fa-users me-2"></i><span data-i18n="nav.team">Our Team</span></a>
                                <a href="{{ url('/testimonial') }}" class="dropdown-item"><i class="fas fa-comments me-2"></i><span data-i18n="nav.testimonial">Testimonial</span></a>
                                <a href="{{ url('/not-found') }}" class="dropdown-item"><i class="fas fa-triangle-exclamation me-2"></i><span data-i18n="nav.notfound">404 Page</span></a>
                            </div>
                        </div>
                    </div>
                    <div class="nav-toolbar" aria-label="Quick controls">
                        <button class="nav-toolbar__btn" id="themeToggle" type="button" aria-label="Toggle theme">
                            <span class="nav-toolbar__icon" id="themeIcon">🌙</span>
                            <span class="nav-toolbar__text" id="themeLabel" data-i18n="controls.dark">Dark</span>
                        </button>
                        <button class="nav-toolbar__btn" id="languageToggle" type="button" aria-label="Toggle language">
                            <span class="nav-toolbar__icon">🌍</span>
                            <span class="nav-toolbar__text" id="languageLabel">AR</span>
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
