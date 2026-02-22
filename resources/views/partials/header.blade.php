        <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->


        <!-- Topbar Start -->
        <div class="container-fluid bg-dark px-5 d-none d-lg-block">
            <div class="row gx-0 align-items-center" style="height: 45px;">
                <div class="col-lg-8 text-center text-lg-start mb-lg-0">
                    <div class="d-flex flex-wrap">
                        <a href="#" class="text-light me-4"><i class="fas fa-map-marker-alt text-primary me-2"></i>Find A Location</a>
                        <a href="#" class="text-light me-4"><i class="fas fa-phone-alt text-primary me-2"></i>+01234567890</a>
                        <a href="#" class="text-light me-0"><i class="fas fa-envelope text-primary me-2"></i>Example@gmail.com</a>
                    </div>
                </div>
                <div class="col-lg-4 text-center text-lg-end">
                    <div class="d-flex align-items-center justify-content-end">
                        <a href="#" class="btn btn-light btn-square border rounded-circle nav-fill me-3"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="btn btn-light btn-square border rounded-circle nav-fill me-3"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="btn btn-light btn-square border rounded-circle nav-fill me-3"><i class="fab fa-instagram"></i></a>
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
                    <h1 class="text-primary m-0"><i class="fas fa-star-of-life me-3"></i>Terapia</h1>
                    <!-- <img src="img/logo.png" alt="Logo"> -->
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                    <span class="fa fa-bars"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <div class="navbar-nav ms-auto py-0">
                        <a href="{{ url('/') }}" class="nav-item nav-link active">Home</a>
                        <a href="{{ url('/about') }}" class="nav-item nav-link">About</a>
                        <a href="{{ url('/service') }}" class="nav-item nav-link">Services</a>

                        <div class="nav-item mega-menu" id="productsMegaMenu">
                            <button
                                class="nav-link mega-menu__trigger"
                                type="button"
                                aria-expanded="false"
                                aria-controls="productsMegaPanel"
                            >
                                Products
                                <span class="mega-menu__caret" aria-hidden="true">▾</span>
                            </button>

                            <section class="mega-menu__panel" id="productsMegaPanel" aria-label="Products Mega Menu">
                                <div class="mega-menu__inner">
                                    <div class="mega-menu__grid">
                                        <article class="mega-menu__category">
                                            <h4 class="mega-menu__heading">Restaurant</h4>
                                            <button class="mega-menu__category-toggle" type="button" aria-expanded="false">Restaurant</button>
                                            <div class="mega-menu__services">
                                                <a href="#" class="mega-menu__service">
                                                    <img src="https://via.placeholder.com/60x60.png?text=POS" alt="Restaurant POS">
                                                    <div>
                                                        <h5>Restaurant POS</h5>
                                                        <p>Smart table, order and kitchen workflows.</p>
                                                    </div>
                                                </a>
                                                <a href="#" class="mega-menu__service">
                                                    <img src="https://via.placeholder.com/60x60.png?text=QR" alt="QR Ordering">
                                                    <div>
                                                        <h5>QR Ordering</h5>
                                                        <p>Contactless menu and payment journey.</p>
                                                    </div>
                                                </a>
                                            </div>
                                        </article>

                                        <article class="mega-menu__category">
                                            <h4 class="mega-menu__heading">Retail</h4>
                                            <button class="mega-menu__category-toggle" type="button" aria-expanded="false">Retail</button>
                                            <div class="mega-menu__services">
                                                <a href="#" class="mega-menu__service">
                                                    <img src="https://via.placeholder.com/60x60.png?text=INV" alt="Inventory Hub">
                                                    <div>
                                                        <h5>Inventory Hub</h5>
                                                        <p>Centralized stock sync across all stores.</p>
                                                    </div>
                                                </a>
                                                <a href="#" class="mega-menu__service">
                                                    <img src="https://via.placeholder.com/60x60.png?text=CRM" alt="Loyalty CRM">
                                                    <div>
                                                        <h5>Loyalty CRM</h5>
                                                        <p>Member tiers, rewards and campaigns.</p>
                                                    </div>
                                                </a>
                                            </div>
                                        </article>

                                        <article class="mega-menu__category">
                                            <h4 class="mega-menu__heading">Hotel</h4>
                                            <button class="mega-menu__category-toggle" type="button" aria-expanded="false">Hotel</button>
                                            <div class="mega-menu__services">
                                                <a href="#" class="mega-menu__service">
                                                    <img src="https://via.placeholder.com/60x60.png?text=PMS" alt="Property PMS">
                                                    <div>
                                                        <h5>Property PMS</h5>
                                                        <p>Bookings, front desk and room operations.</p>
                                                    </div>
                                                </a>
                                                <a href="#" class="mega-menu__service">
                                                    <img src="https://via.placeholder.com/60x60.png?text=SPA" alt="Spa & Wellness">
                                                    <div>
                                                        <h5>Spa & Wellness</h5>
                                                        <p>Appointments and service bundles in one place.</p>
                                                    </div>
                                                </a>
                                            </div>
                                        </article>

                                        <article class="mega-menu__category">
                                            <h4 class="mega-menu__heading">Enterprise</h4>
                                            <button class="mega-menu__category-toggle" type="button" aria-expanded="false">Enterprise</button>
                                            <div class="mega-menu__services">
                                                <a href="#" class="mega-menu__service">
                                                    <img src="https://via.placeholder.com/60x60.png?text=BI" alt="BI Analytics">
                                                    <div>
                                                        <h5>BI Analytics</h5>
                                                        <p>Executive dashboards with live insights.</p>
                                                    </div>
                                                </a>
                                                <a href="#" class="mega-menu__service">
                                                    <img src="https://via.placeholder.com/60x60.png?text=API" alt="API Integrations">
                                                    <div>
                                                        <h5>API Integrations</h5>
                                                        <p>Secure integrations with ERP and finance tools.</p>
                                                    </div>
                                                </a>
                                            </div>
                                        </article>
                                    </div>
                                </div>
                            </section>
                        </div>

                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Pages</a>
                            <div class="dropdown-menu m-0">
                                <a href="{{ url('/appointment') }}" class="dropdown-item">Appointment</a>
                                <a href="{{ url('/feature') }}" class="dropdown-item">Features</a>
                                <a href="{{ url('/blog') }}" class="dropdown-item">Our Blog</a>
                                <a href="{{ url('/team') }}" class="dropdown-item">Our Team</a>
                                <a href="{{ url('/testimonial') }}" class="dropdown-item">Testimonial</a>
                                <a href="{{ url('/not-found') }}" class="dropdown-item">404 Page</a>
                            </div>
                        </div>
                        <a href="{{ url('/contact') }}" class="nav-item nav-link">Contact Us</a>
                    </div>
                    <a href="#" class="btn btn-primary rounded-pill text-white py-2 px-4 flex-wrap flex-sm-shrink-0">Book Appointment</a>
                </div>
            </nav>


            @if($showCarousel ?? false)

            <!-- Carousel Start -->
            <div class="header-carousel owl-carousel">
                <div class="header-carousel-item">
                    <img src="{{ asset('img/carousel-1.jpg') }}" class="img-fluid w-100" alt="Image">
                    <div class="carousel-caption">
                        <div class="carousel-caption-content p-3">
                            <h5 class="text-white text-uppercase fw-bold mb-4" style="letter-spacing: 3px;">Physiotherapy Center</h5>
                            <h1 class="display-1 text-capitalize text-white mb-4">Best Solution For Painful Life</h1>
                            <p class="mb-5 fs-5">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, 
                            </p>
                            <a class="btn btn-primary rounded-pill text-white py-3 px-5" href="#">Book Appointment</a>
                        </div>
                    </div>
                </div>
                <div class="header-carousel-item">
                    <img src="{{ asset('img/carousel-2.jpg') }}" class="img-fluid w-100" alt="Image">
                    <div class="carousel-caption">
                        <div class="carousel-caption-content p-3">
                            <h5 class="text-white text-uppercase fw-bold mb-4" style="letter-spacing: 3px;">Physiotherapy Center</h5>
                            <h1 class="display-1 text-capitalize text-white mb-4">Best Solution For Painful Life</h1>
                            <p class="mb-5 fs-5 animated slideInDown">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, 
                            </p>
                            <a class="btn btn-primary rounded-pill text-white py-3 px-5" href="#">Book Appointment</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Carousel End -->
            @endif
        </div>
        <!-- Navbar & Hero End -->
