@extends('layouts.app')

@section('content')
@php($showCarousel = true)


        <!-- Services Start -->
        <div class="container-fluid service py-5">
            <div class="container py-5">
                <div class="section-title mb-5 wow fadeInUp" data-wow-delay="0.2s">
                    <div class="sub-style">
                        <h4 class="sub-title px-3 mb-0">What We Do</h4>
                    </div>
                    <h1 class="display-3 mb-4">Powerful POS System for Restaurants & Retail.</h1>
                    <p class="mb-0">AQUA POS is a cloud-based POS and inventory management platform from Amman, Jordan, helping restaurants and retailers run faster with better control and full visibility.</p>
                </div>

                <div class="row g-4 justify-content-center">
                    @forelse(($featuredProducts ?? collect()) as $index => $product)
                        <div class="col-md-6 col-lg-4 col-xl-3 d-flex wow fadeInUp" data-wow-delay="{{ number_format((($index % 4) * 0.2) + 0.1, 1) }}s">
                            <div class="service-item rounded h-100 d-flex flex-column">
                                <div class="service-img rounded-top">
                                    <img src="{{ $product->image_url }}" class="img-fluid rounded-top w-100" alt="{{ $product->localized_name }}">
                                </div>
                                <div class="service-content rounded-bottom bg-light p-4 d-flex flex-column flex-grow-1">
                                    <div class="service-content-inner d-flex flex-column h-100">
                                        <h5 class="mb-3">{{ $product->localized_name }}</h5>
                                        <p class="mb-4">{{ \Illuminate\Support\Str::limit($product->localized_short_description ?: $product->localized_description ?: 'Explore this product in detail.', 120) }}</p>
                                        <div class="mt-auto pt-2">
                                            <a href="{{ route('products.show', $product->slug) }}" class="btn btn-primary rounded-pill text-white py-2 px-4 mb-2">Read More</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center">
                            <p class="text-muted mb-3">No active products available right now.</p>
                        </div>
                    @endforelse

                    <div class="col-12 text-center wow fadeInUp" data-wow-delay="0.2s">
                        <a class="btn btn-primary rounded-pill text-white py-3 px-5" href="{{ route('products') }}">Services More</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Services End -->


        <!-- About Start -->
        <div class="container-fluid about bg-light py-5">
            <div class="container py-5">
                <div class="row g-5 align-items-center">
                    <div class="col-lg-5 wow fadeInLeft" data-wow-delay="0.2s">
                        <div class="about-img">
                            <img src="{{ asset('img/about-1.jpg') }}" class="img-fluid rounded w-100 h-100 about-img-main" alt="Image">
                            <div class="about-img-inner">
                                <img src="{{ asset('img/about-2.jpg') }}" class="img-fluid rounded-circle w-100 h-100" alt="Image">
                            </div>
                            <div class="about-experience">Trusted in Amman, Jordan</div>
                        </div>
                    </div>
                    <div class="col-lg-7 wow fadeInRight" data-wow-delay="0.4s">
                        <div class="section-title text-start mb-5">
                            <h4 class="sub-title pe-3 mb-0">About Us</h4>
                            <h1 class="display-3 mb-4">Jordanian SaaS Team Building Better POS Operations.</h1>
                            <p class="mb-4">AQUA POS is a cloud-based POS and inventory management platform from Amman, Jordan, helping restaurants and retailers run faster with better control and full visibility.</p>
                            <div class="mb-4">
                                <p class="text-secondary"><i class="fa fa-check text-primary me-2"></i> Built for restaurants and retail businesses.</p>
                                <p class="text-secondary"><i class="fa fa-check text-primary me-2"></i> Reduce billing and stock errors across teams.</p>
                                <p class="text-secondary"><i class="fa fa-check text-primary me-2"></i> Improve speed, control, and daily visibility.</p>
                            </div>
                            <a href="#" class="btn btn-primary rounded-pill text-white py-3 px-5">Discover More</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- About End -->

        <!-- Feature Start -->
        <div class="container-fluid feature py-5">
            <div class="container py-5">
                <div class="section-title mb-5 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="sub-style">
                        <h4 class="sub-title px-3 mb-0">Why Choose Us</h4>
                    </div>
                    <h1 class="display-3 mb-4">Why Choose Us? Run Smarter Operations Every Day</h1>
                    <p class="mb-0">AQUA POS is a cloud-based POS and inventory management platform from Amman, Jordan, helping restaurants and retailers run faster with better control and full visibility.</p>
                </div>
                <div class="row g-4 justify-content-center">
                    <div class="col-md-6 col-lg-4 col-xl-3 d-flex wow fadeInUp" data-wow-delay="0.1s">
                        <div class="row-cols-1 feature-item p-4 h-100 d-flex flex-column">
                            <div class="col-12">
                                <div class="feature-icon mb-4">
                                    <div class="p-3 d-inline-flex bg-white rounded">
                                        <i class="fas fa-cash-register text-primary"></i>
                                    </div>
                                </div>
                                <div class="feature-content d-flex flex-column flex-grow-1">
                                    <h5 class="mb-4">Reliable POS Workflows</h5>
                                    <p class="mb-0">Built to keep sales, stock, and branch performance connected in one reliable cloud system.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4 col-xl-3 d-flex wow fadeInUp" data-wow-delay="0.3s">
                        <div class="row-cols-1 feature-item p-4 h-100 d-flex flex-column">
                            <div class="col-12">
                                <div class="feature-icon mb-4">
                                    <div class="p-3 d-inline-flex bg-white rounded">
                                        <i class="fas fa-boxes text-primary"></i>
                                    </div>
                                </div>
                                <div class="feature-content d-flex flex-column flex-grow-1">
                                    <h5 class="mb-4">Smart Inventory Control</h5>
                                    <p class="mb-0">Built to keep sales, stock, and branch performance connected in one reliable cloud system.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4 col-xl-3 d-flex wow fadeInUp" data-wow-delay="0.5s">
                        <div class="row-cols-1 feature-item p-4 h-100 d-flex flex-column">
                            <div class="col-12">
                                <div class="feature-icon mb-4">
                                    <div class="p-3 d-inline-flex bg-white rounded">
                                        <i class="fas fa-chart-line text-primary"></i>
                                    </div>
                                </div>
                                <div class="feature-content d-flex flex-column flex-grow-1">
                                    <h5 class="mb-4">Real-Time Business Insights</h5>
                                    <p class="mb-0">Built to keep sales, stock, and branch performance connected in one reliable cloud system.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4 col-xl-3 d-flex wow fadeInUp" data-wow-delay="0.7s">
                        <div class="row-cols-1 feature-item p-4 h-100 d-flex flex-column">
                            <div class="col-12">
                                <div class="feature-icon mb-4">
                                    <div class="p-3 d-inline-flex bg-white rounded">
                                        <i class="fas fa-code-branch text-primary"></i>
                                    </div>
                                </div>
                                <div class="feature-content d-flex flex-column flex-grow-1">
                                    <h5 class="mb-4">Unified Branch Management</h5>
                                    <p class="mb-0">Built to keep sales, stock, and branch performance connected in one reliable cloud system.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4 col-xl-3 d-flex wow fadeInUp" data-wow-delay="0.1s">
                        <div class="row-cols-1 feature-item p-4 h-100 d-flex flex-column">
                            <div class="col-12">
                                <div class="feature-icon mb-4">
                                    <div class="p-3 d-inline-flex bg-white rounded">
                                        <i class="fas fa-bolt text-primary"></i>
                                    </div>
                                </div>
                                <div class="feature-content d-flex flex-column flex-grow-1">
                                    <h5 class="mb-4">Fast Checkout Experience</h5>
                                    <p class="mb-0">Built to keep sales, stock, and branch performance connected in one reliable cloud system.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4 col-xl-3 d-flex wow fadeInUp" data-wow-delay="0.3s">
                        <div class="row-cols-1 feature-item p-4 h-100 d-flex flex-column">
                            <div class="col-12">
                                <div class="feature-icon mb-4">
                                    <div class="p-3 d-inline-flex bg-white rounded">
                                        <i class="fas fa-users text-primary"></i>
                                    </div>
                                </div>
                                <div class="feature-content d-flex flex-column flex-grow-1">
                                    <h5 class="mb-4">Jordan-Based SaaS Team</h5>
                                    <p class="mb-0">Built to keep sales, stock, and branch performance connected in one reliable cloud system.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4 col-xl-3 d-flex wow fadeInUp" data-wow-delay="0.5s">
                        <div class="row-cols-1 feature-item p-4 h-100 d-flex flex-column">
                            <div class="col-12">
                                <div class="feature-icon mb-4">
                                    <div class="p-3 d-inline-flex bg-white rounded">
                                        <i class="fas fa-chart-pie text-primary"></i>
                                    </div>
                                </div>
                                <div class="feature-content d-flex flex-column flex-grow-1">
                                    <h5 class="mb-4">Real-Time Analytics</h5>
                                    <p class="mb-0">Built to keep sales, stock, and branch performance connected in one reliable cloud system.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4 col-xl-3 d-flex wow fadeInUp" data-wow-delay="0.7s">
                        <div class="row-cols-1 feature-item p-4 h-100 d-flex flex-column">
                            <div class="col-12">
                                <div class="feature-icon mb-4">
                                    <div class="p-3 d-inline-flex bg-white rounded">
                                        <i class="fas fa-eye text-primary"></i>
                                    </div>
                                </div>
                                <div class="feature-content d-flex flex-column flex-grow-1">
                                    <h5 class="mb-4">Control & Visibility</h5>
                                    <p class="mb-0">Built to keep sales, stock, and branch performance connected in one reliable cloud system.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 text-center wow fadeInUp" data-wow-delay="0.2s">
                        <a href="#" class="btn btn-primary rounded-pill text-white py-3 px-5">More Details</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Feature End -->


        <!-- Book Appointment Start -->
        <div class="container-fluid appointment py-5">
            <div class="container py-5">
                <div class="row g-5 align-items-center">
                    <div class="col-lg-6 wow fadeInLeft" data-wow-delay="0.2">
                        <div class="section-title text-start">
                            <h4 class="sub-title pe-3 mb-0">Solutions To Your Pain</h4>
                            <h1 class="display-4 mb-4">Best Quality Services With Minimal Pain Rate</h1>
                            <p class="mb-4">AQUA POS is a cloud-based POS and inventory management platform from Amman, Jordan, helping restaurants and retailers run faster with better control and full visibility.</p>
                            <div class="row g-4">
                                <div class="col-sm-6">
                                    <div class="d-flex flex-column h-100">
                                        <div class="mb-4">
                                            <h5 class="mb-3"><i class="fa fa-check text-primary me-2"></i> Body Relaxation</h5>
                                            <p class="mb-0">From onboarding to go-live, our team ensures a smooth deployment with clear workflows and measurable operational improvements.</p>
                                        </div>
                                        <div class="mb-4">
                                            <h5 class="mb-3"><i class="fa fa-check text-primary me-2"></i> Body Relaxation</h5>
                                            <p class="mb-0">From onboarding to go-live, our team ensures a smooth deployment with clear workflows and measurable operational improvements.</p>
                                        </div>
                                        <div class="text-start mb-4">
                                            <a href="#" class="btn btn-primary rounded-pill text-white py-3 px-5">More Details</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="video h-100">
                                        <img src="{{ asset('img/video-img.jpg') }}" class="img-fluid rounded w-100 h-100" style="object-fit: cover;" alt="">
                                        <button type="button" class="btn btn-play" data-bs-toggle="modal" data-src="https://www.youtube.com/embed/DWRcNpR6Kdc" data-bs-target="#videoModal">
                                            <span></span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 wow fadeInRight" data-wow-delay="0.4s">
                        <div class="appointment-form rounded p-5">
                            <p class="fs-4 text-uppercase text-primary">Get In Touch</p>
                            <h1 class="display-5 mb-4">Get Appointment</h1>
                            <form>
                                <div class="row gy-3 gx-4">
                                    <div class="col-xl-6">
                                        <input type="text" class="form-control py-3 border-primary bg-transparent text-white" placeholder="First Name">
                                    </div>
                                    <div class="col-xl-6">
                                        <input type="email" class="form-control py-3 border-primary bg-transparent text-white" placeholder="Email">
                                    </div>
                                    <div class="col-xl-6">
                                        <input type="phone" class="form-control py-3 border-primary bg-transparent" placeholder="Phone">
                                    </div>
                                    <div class="col-xl-6">
                                        <select class="form-select py-3 border-primary bg-transparent" aria-label="Default select example">
                                            <option selected>Your Gender</option>
                                            <option value="1">Male</option>
                                            <option value="2">FeMale</option>
                                            <option value="3">Others</option>
                                        </select>
                                    </div>
                                    <div class="col-xl-6">
                                        <input type="date" class="form-control py-3 border-primary bg-transparent">
                                    </div>
                                    <div class="col-xl-6">
                                        <select class="form-select py-3 border-primary bg-transparent" aria-label="Default select example">
                                            <option selected>Department</option>
                                            <option value="1">Smart Inventory Control</option>
                                            <option value="2">Physical Helth</option>
                                            <option value="2">Treatments</option>
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <textarea class="form-control border-primary bg-transparent text-white" name="text" id="area-text" cols="30" rows="5" placeholder="Write Comments"></textarea>
                                    </div>
                                    <div class="col-12">
                                        <button type="button" class="btn btn-primary text-white w-100 py-3 px-5">SUBMIT NOW</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Video -->
        <div class="modal fade" id="videoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content rounded-0">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Youtube Video</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- 16:9 aspect ratio -->
                        <div class="ratio ratio-16x9">
                            <iframe class="embed-responsive-item" src="" id="video" allowfullscreen allowscriptaccess="always"
                                allow="autoplay"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Book Appointment End -->


        <!-- Our Clients Start -->
        <section class="container-fluid clients-section py-5"> 
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
                @else
                    <p class="text-center text-muted" data-i18n="clients.empty">Clients will be published soon.</p>
                @endif
            </div>
        </section>
        <!-- Our Clients End -->


        <!-- Testimonial Start -->
        <div class="container-fluid testimonial py-5 wow zoomInDown" data-wow-delay="0.1s">
            <div class="container py-5">
                <div class="section-title mb-5">
                    <div class="sub-style">
                        <h4 class="sub-title text-white px-3 mb-0">Testimonial</h4>
                    </div>
                    <h1 class="display-3 mb-4">What Clients are Say</h1>
                </div>
                <div class="testimonial-carousel owl-carousel">
                    <div class="testimonial-item">
                        <div class="testimonial-inner p-5">
                            <div class="testimonial-inner-img mb-4">
                                <img src="{{ asset('img/testimonial-img.jpg') }}" class="img-fluid rounded-circle" alt="">
                            </div>
                            <p class="text-white fs-7">AQUA POS gave us a clear live view of sales and stock. Our branch teams now work faster with fewer manual errors and stronger daily control.
                            </p>
                            <div class="text-center">
                                <h5 class="mb-2">John Abraham</h5>
                                <p class="mb-2 text-white-50">New York, USA</p>
                                <div class="d-flex justify-content-center">
                                    <i class="fas fa-star text-secondary"></i>
                                    <i class="fas fa-star text-secondary"></i>
                                    <i class="fas fa-star text-secondary"></i>
                                    <i class="fas fa-star text-secondary"></i>
                                    <i class="fas fa-star text-secondary"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="testimonial-item">
                        <div class="testimonial-inner p-5">
                            <div class="testimonial-inner-img mb-4">
                                <img src="{{ asset('img/testimonial-img.jpg') }}" class="img-fluid rounded-circle" alt="">
                            </div>
                            <p class="text-white fs-7">AQUA POS gave us a clear live view of sales and stock. Our branch teams now work faster with fewer manual errors and stronger daily control.
                            </p>
                            <div class="text-center">
                                <h5 class="mb-2">John Abraham</h5>
                                <p class="mb-2 text-white-50">New York, USA</p>
                                <div class="d-flex justify-content-center">
                                    <i class="fas fa-star text-secondary"></i>
                                    <i class="fas fa-star text-secondary"></i>
                                    <i class="fas fa-star text-secondary"></i>
                                    <i class="fas fa-star text-secondary"></i>
                                    <i class="fas fa-star text-secondary"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="testimonial-item">
                        <div class="testimonial-inner p-5">
                            <div class="testimonial-inner-img mb-4">
                                <img src="{{ asset('img/testimonial-img.jpg') }}" class="img-fluid rounded-circle" alt="">
                            </div>
                            <p class="text-white fs-7">AQUA POS gave us a clear live view of sales and stock. Our branch teams now work faster with fewer manual errors and stronger daily control.
                            </p>
                            <div class="text-center">
                                <h5 class="mb-2">John Abraham</h5>
                                <p class="mb-2 text-white-50">New York, USA</p>
                                <div class="d-flex justify-content-center">
                                    <i class="fas fa-star text-secondary"></i>
                                    <i class="fas fa-star text-secondary"></i>
                                    <i class="fas fa-star text-secondary"></i>
                                    <i class="fas fa-star text-secondary"></i>
                                    <i class="fas fa-star text-secondary"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Testimonial End -->


        <!-- Blog Start -->
        <div class="container-fluid blog py-5">
            <div class="container py-5">
                <div class="section-title mb-5 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="sub-style">
                        <h4 class="sub-title px-3 mb-0">Our Blog</h4>
                    </div>
                    <h1 class="display-3 mb-4">Real-Time Business Insights for Faster Decisions</h1>
                    <p class="mb-0">AQUA POS is a cloud-based POS and inventory management platform from Amman, Jordan, helping restaurants and retailers run faster with better control and full visibility.</p>
                </div>
                <div class="row g-4 justify-content-center">
                    <div class="col-md-6 col-lg-6 col-xl-4 d-flex wow fadeInUp" data-wow-delay="0.1s">
                        <div class="blog-item rounded h-100 d-flex flex-column">
                            <div class="blog-img">
                                <img src="{{ asset('img/blog-1.jpg') }}" class="img-fluid w-100" alt="Image">
                            </div>
                            <div class="blog-centent p-4 d-flex flex-column flex-grow-1">
                                <div class="d-flex justify-content-between mb-4">
                                    <p class="mb-0 text-muted"><i class="fa fa-calendar-alt text-primary"></i> 01 Jan 2045</p>
                                    <a href="#" class="text-muted"><span class="fa fa-comments text-primary"></span> 3 Comments</a>
                                </div>
                                <a href="#" class="h4 d-block mb-3">Remove back Pain While Working on o physio</a>
                                <p class="my-4">Practical strategies for improving checkout speed, stock accuracy, and branch coordination using a modern SaaS POS platform.</p>
                                <div class="mt-auto pt-2">
                                    <a href="#" class="btn btn-primary rounded-pill text-white py-2 px-4 mb-1">Read More</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-xl-4 d-flex wow fadeInUp" data-wow-delay="0.3s">
                        <div class="blog-item rounded h-100 d-flex flex-column">
                            <div class="blog-img">
                                <img src="{{ asset('img/blog-2.jpg') }}" class="img-fluid w-100" alt="Image">
                            </div>
                            <div class="blog-centent p-4 d-flex flex-column flex-grow-1">
                                <div class="d-flex justify-content-between mb-4">
                                    <p class="mb-0 text-muted"><i class="fa fa-calendar-alt text-primary"></i> 01 Jan 2045</p>
                                    <a href="#" class="text-muted"><span class="fa fa-comments text-primary"></span> 3 Comments</a>
                                </div>
                                <a href="#" class="h4 d-block mb-3">Inventory accuracy tips for multi-branch stores</a>
                                <p class="my-4">Practical strategies for improving checkout speed, stock accuracy, and branch coordination using a modern SaaS POS platform.</p>
                                <div class="mt-auto pt-2">
                                    <a href="#" class="btn btn-primary rounded-pill text-white py-2 px-4 mb-1">Read More</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-xl-4 d-flex wow fadeInUp" data-wow-delay="0.5s">
                        <div class="blog-item rounded h-100 d-flex flex-column">
                            <div class="blog-img">
                                <img src="{{ asset('img/blog-3.jpg') }}" class="img-fluid w-100" alt="Image">
                            </div>
                            <div class="blog-centent p-4 d-flex flex-column flex-grow-1">
                                <div class="d-flex justify-content-between mb-4">
                                    <p class="mb-0 text-muted"><i class="fa fa-calendar-alt text-primary"></i> 01 Jan 2045</p>
                                    <a href="#" class="text-muted"><span class="fa fa-comments text-primary"></span> 3 Comments</a>
                                </div>
                                <a href="#" class="h4 d-block mb-3">Regular excercise can slow ageing process</a>
                                <p class="my-4">Practical strategies for improving checkout speed, stock accuracy, and branch coordination using a modern SaaS POS platform.</p>
                                <div class="mt-auto pt-2">
                                    <a href="#" class="btn btn-primary rounded-pill text-white py-2 px-4 mb-1">Read More</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Blog End -->


        
@endsection
@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const el = document.querySelector('.clients-swiper');
        if (!el) return;

        let clientsSwiper;

        const initClientsSwiper = function () {
            if (clientsSwiper) {
                clientsSwiper.destroy(true, true);
            }

            clientsSwiper = new Swiper(el, {
                slidesPerView: 2,
                spaceBetween: 14,
                autoplay: { delay: 2600, disableOnInteraction: false },
                loop: true,
                rtl: document.documentElement.getAttribute('dir') === 'rtl',
                breakpoints: {
                    640: { slidesPerView: 3 },
                    768: { slidesPerView: 4 },
                    1200: { slidesPerView: 6 }
                }
            });
        };

        initClientsSwiper();
        document.addEventListener('aqua:language-changed', initClientsSwiper);
    });
</script>
@endpush
