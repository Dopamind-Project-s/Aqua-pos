        <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->

        <!-- Topbar Start -->
        <div class="container-fluid bg-dark px-4 px-lg-5 d-none d-lg-block">
            <div class="row gx-0 align-items-center" style="height: 48px;">
                <div class="col-lg-8 text-center text-lg-start">
                    <div class="d-flex flex-wrap align-items-center gap-4">
                        <span class="text-light"><i class="fas fa-map-marker-alt text-primary me-2"></i>Amman, Jordan</span>
                        <a href="tel:+962791888655" class="text-light"><i class="fas fa-phone-alt text-primary me-2"></i>+962 79 1888655</a>
                        <a href="mailto:info@aqua-pos.com" class="text-light"><i class="fas fa-envelope text-primary me-2"></i>info@aqua-pos.com</a>
                    </div>
                </div>
                <div class="col-lg-4 text-center text-lg-end">
                    <span class="text-light fw-semibold">POS &amp; Inventory Management Software</span>
                </div>
            </div>
        </div>
        <!-- Topbar End -->

        <!-- Navbar & Hero Start -->
        <div class="container-fluid position-relative p-0">
            <nav class="navbar navbar-expand-lg navbar-light bg-white px-4 px-lg-5 py-3 py-lg-0">
                <a href="{{ url('/') }}" class="navbar-brand p-0 aqua-logo-wrap">
                    <span class="aqua-logo-placeholder">A</span>
                    <h1 class="text-primary m-0 aqua-brand-text">AQUA <span class="brand-pos">POS</span></h1>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                    <span class="fa fa-bars"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <div class="navbar-nav ms-auto py-0 align-items-lg-center">
                        <a href="{{ url('/') }}" class="nav-item nav-link active">Home</a>

                        <div class="nav-item mega-menu" id="productsMegaMenu">
                            <button class="nav-link mega-menu__trigger" type="button" aria-expanded="false" aria-controls="productsMegaPanel">
                                Products
                                <span class="mega-menu__caret" aria-hidden="true">▾</span>
                            </button>

                            <section class="mega-menu__panel" id="productsMegaPanel" aria-label="Products Mega Menu">
                                <div class="mega-menu__inner">
                                    <div class="mega-menu__grid aqua-mega-grid">
                                        <article class="mega-menu__category">
                                            <h4 class="mega-menu__heading">Restaurants</h4>
                                            <button class="mega-menu__category-toggle" type="button" aria-expanded="false">Restaurants</button>
                                            <div class="mega-menu__services">
                                                <a href="#" class="mega-menu__service"><div><h5>Point of Sale</h5></div></a>
                                                <a href="#inventory" class="mega-menu__service"><div><h5>Inventory Management</h5></div></a>
                                                <a href="#" class="mega-menu__service"><div><h5>Table Reservation</h5></div></a>
                                                <a href="#" class="mega-menu__service"><div><h5>QR Digital Menu</h5></div></a>
                                            </div>
                                        </article>

                                        <article class="mega-menu__category">
                                            <h4 class="mega-menu__heading">Retail</h4>
                                            <button class="mega-menu__category-toggle" type="button" aria-expanded="false">Retail</button>
                                            <div class="mega-menu__services">
                                                <a href="#" class="mega-menu__service"><div><h5>Point of Sale</h5></div></a>
                                                <a href="#inventory" class="mega-menu__service"><div><h5>Inventory Management</h5></div></a>
                                                <a href="#" class="mega-menu__service"><div><h5>Accounting</h5></div></a>
                                            </div>
                                        </article>
                                    </div>
                                </div>
                            </section>
                        </div>

                        <a href="#" class="nav-item nav-link">Support</a>
                        <a href="#" class="nav-item nav-link">Company</a>
                        <a href="#" class="nav-item nav-link">Partners</a>
                    </div>

                    <form class="aqua-search" role="search">
                        <input type="search" class="form-control" placeholder="Search" aria-label="Search">
                        <button type="submit" aria-label="Submit search"><i class="fas fa-search"></i></button>
                    </form>
                </div>
            </nav>

            @if($showCarousel ?? false)
            <div class="header-carousel owl-carousel">
                <div class="header-carousel-item">
                    <img src="{{ asset('img/carousel-1.jpg') }}" class="img-fluid w-100" alt="Aqua POS dashboard preview">
                    <div class="carousel-caption">
                        <div class="carousel-caption-content p-3">
                            <h5 class="text-white text-uppercase fw-bold mb-4" style="letter-spacing: 3px;">AQUA POS &amp; Inventory Management</h5>
                            <h1 class="display-1 text-capitalize text-white mb-4">Powerful <span class="brand-pos">POS</span> System For Growing Businesses</h1>
                            <p class="mb-5 fs-5">Built for restaurants and retail teams that need speed, control and real-time visibility across branches.</p>
                            <a class="btn btn-primary rounded-pill text-white py-3 px-5" href="#inventory">Explore Inventory Software</a>
                        </div>
                    </div>
                </div>
                <div class="header-carousel-item">
                    <img src="{{ asset('img/carousel-2.jpg') }}" class="img-fluid w-100" alt="Inventory and POS software">
                    <div class="carousel-caption">
                        <div class="carousel-caption-content p-3">
                            <h5 class="text-white text-uppercase fw-bold mb-4" style="letter-spacing: 3px;">Trusted POS Technology</h5>
                            <h1 class="display-1 text-capitalize text-white mb-4">Unified <span class="brand-pos">POS</span> + Inventory Software</h1>
                            <p class="mb-5 fs-5 animated slideInDown">Manage orders, stock and branch performance in one connected SaaS platform.</p>
                            <a class="btn btn-primary rounded-pill text-white py-3 px-5" href="#inventory">Request a Demo</a>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
        <!-- Navbar & Hero End -->
