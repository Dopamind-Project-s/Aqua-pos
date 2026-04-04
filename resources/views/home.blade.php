@extends('layouts.app')

@section('content')
@php($showCarousel = true)


        <!-- Category Explorer Start -->
        <div class="container-fluid service py-5">
            <div class="container py-5">
                <div class="section-title mb-5 wow fadeInUp" data-wow-delay="0.2s">
                    <div class="sub-style">
                        <h4 class="sub-title px-3 mb-0">CATEGORY SPOTLIGHT</h4>
                    </div>
                    <h1 class="display-3 mb-4">Explore Solutions by Business Category</h1>
                    <p class="mb-0">Pick your business category to discover relevant products, client brands, and deployment-ready workflows.</p>
                </div>

                <div class="row g-4 justify-content-center">
                    @forelse(($featuredCategories ?? collect()) as $index => $category)
                        <div class="col-md-6 col-lg-4 col-xl-3 d-flex wow fadeInUp" data-wow-delay="{{ number_format((($index % 4) * 0.2) + 0.1, 1) }}s">
                            <div class="service-item rounded h-100 d-flex flex-column">
                                <div class="service-img rounded-top">
                                    <img src="{{ $category->image_url }}" class="img-fluid rounded-top w-100" alt="{{ $category->localized_name }}">
                                </div>
                                <div class="service-content rounded-bottom bg-light p-4 d-flex flex-column flex-grow-1">
                                    <div class="service-content-inner d-flex flex-column h-100">
                                        <h5 class="mb-3">{{ $category->localized_name }}</h5>
                                        <p class="mb-2">{{ \Illuminate\Support\Str::limit($category->localized_description ?: 'Category tailored for scalable operations and better control.', 110) }}</p>
                                        <p class="small text-muted mb-4"><i class="fas fa-box-open me-1"></i>{{ $category->products_count }} products</p>
                                        <div class="mt-auto pt-2">
                                            <a href="{{ route('categories.show', $category->slug) }}" class="btn btn-primary rounded-pill text-white py-2 px-4 mb-2">Explore Category</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center">
                            <p class="text-muted mb-3">No active categories available right now.</p>
                        </div>
                    @endforelse

                    <div class="col-12 text-center wow fadeInUp" data-wow-delay="0.2s">
                        <a class="btn btn-primary rounded-pill text-white py-3 px-5" href="{{ route('products') }}">Browse All Products</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Category Explorer End -->


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
                            <div class="about-experience"><span data-i18n="home.about.badge">Trusted in Amman, Jordan</span></div>
                        </div>
                    </div>
                    <div class="col-lg-7 wow fadeInRight" data-wow-delay="0.4s">
                        <div class="section-title text-start mb-5">
                            <h4 class="sub-title pe-3 mb-0"><span data-i18n="home.about.eyebrow">About Us</span></h4>
                            <h1 class="display-3 mb-4"><span data-i18n="home.about.title">Jordanian SaaS Team Building Better POS Operations.</span></h1>
                            <p class="mb-4"><span data-i18n="home.common.description">AQUA POS is a cloud-based POS and inventory management platform from Amman, Jordan, helping restaurants and retailers run faster with better control and full visibility.</span></p>
                            <div class="mb-4">
                                <p class="text-secondary"><i class="fa fa-check text-primary me-2"></i><span data-i18n="home.about.point1"> Built for restaurants and retail businesses.</span></p>
                                <p class="text-secondary"><i class="fa fa-check text-primary me-2"></i><span data-i18n="home.about.point2"> Reduce billing and stock errors across teams.</span></p>
                                <p class="text-secondary"><i class="fa fa-check text-primary me-2"></i><span data-i18n="home.about.point3"> Improve speed, control, and daily visibility.</span></p>
                            </div>
                            <a href="{{ route('about') }}" class="btn btn-primary rounded-pill text-white py-3 px-5"><span data-i18n="home.about.more">Discover More</span></a>
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
                        <h4 class="sub-title px-3 mb-0"><span data-i18n="home.features.eyebrow">Why Choose Us</span></h4>
                    </div>
                    <h1 class="display-3 mb-4"><span data-i18n="home.features.title">Why Choose Us? Run Smarter Operations Every Day</span></h1>
                    <p class="mb-0"><span data-i18n="home.common.description">AQUA POS is a cloud-based POS and inventory management platform from Amman, Jordan, helping restaurants and retailers run faster with better control and full visibility.</span></p>
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
                                    <h5 class="mb-4"><span data-i18n="home.features.card1.title">Reliable POS Workflows</span></h5>
                                    <p class="mb-0"><span data-i18n="home.features.card.desc">Built to keep sales, stock, and branch performance connected in one reliable cloud system.</span></p>
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
                                    <h5 class="mb-4"><span data-i18n="home.features.card2.title">Smart Inventory Control</span></h5>
                                    <p class="mb-0"><span data-i18n="home.features.card.desc">Built to keep sales, stock, and branch performance connected in one reliable cloud system.</span></p>
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
                                    <h5 class="mb-4"><span data-i18n="home.features.card3.title">Real-Time Business Insights</span></h5>
                                    <p class="mb-0"><span data-i18n="home.features.card.desc">Built to keep sales, stock, and branch performance connected in one reliable cloud system.</span></p>
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
                                    <h5 class="mb-4"><span data-i18n="home.features.card4.title">Unified Branch Management</span></h5>
                                    <p class="mb-0"><span data-i18n="home.features.card.desc">Built to keep sales, stock, and branch performance connected in one reliable cloud system.</span></p>
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
                                    <h5 class="mb-4"><span data-i18n="home.features.card5.title">Fast Checkout Experience</span></h5>
                                    <p class="mb-0"><span data-i18n="home.features.card.desc">Built to keep sales, stock, and branch performance connected in one reliable cloud system.</span></p>
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
                                    <h5 class="mb-4"><span data-i18n="home.features.card6.title">Jordan-Based SaaS Team</span></h5>
                                    <p class="mb-0"><span data-i18n="home.features.card.desc">Built to keep sales, stock, and branch performance connected in one reliable cloud system.</span></p>
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
                                    <h5 class="mb-4"><span data-i18n="home.features.card7.title">Real-Time Analytics</span></h5>
                                    <p class="mb-0"><span data-i18n="home.features.card.desc">Built to keep sales, stock, and branch performance connected in one reliable cloud system.</span></p>
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
                                    <h5 class="mb-4"><span data-i18n="home.features.card8.title">Control & Visibility</span></h5>
                                    <p class="mb-0"><span data-i18n="home.features.card.desc">Built to keep sales, stock, and branch performance connected in one reliable cloud system.</span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 text-center wow fadeInUp" data-wow-delay="0.2s">
                        <a href="{{ route('feature') }}" class="btn btn-primary rounded-pill text-white py-3 px-5"><span data-i18n="home.common.moreDetails">More Details</span></a>
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
                            <h4 class="sub-title pe-3 mb-0"><span data-i18n="home.solution.eyebrow">Solutions To Your Pain</span></h4>
                            <h1 class="display-4 mb-4"><span data-i18n="home.solution.title">Best Quality Services With Minimal Pain Rate</span></h1>
                            <p class="mb-4"><span data-i18n="home.common.description">AQUA POS is a cloud-based POS and inventory management platform from Amman, Jordan, helping restaurants and retailers run faster with better control and full visibility.</span></p>
                            <div class="row g-4">
                                <div class="col-sm-6">
                                    <div class="d-flex flex-column h-100">
                                        <div class="mb-4">
                                            <h5 class="mb-3"><i class="fa fa-check text-primary me-2"></i><span data-i18n="home.solution.itemTitle"> Body Relaxation</span></h5>
                                            <p class="mb-0"><span data-i18n="home.solution.itemDesc">From onboarding to go-live, our team ensures a smooth deployment with clear workflows and measurable operational improvements.</span></p>
                                        </div>
                                        <div class="mb-4">
                                            <h5 class="mb-3"><i class="fa fa-check text-primary me-2"></i><span data-i18n="home.solution.itemTitle"> Body Relaxation</span></h5>
                                            <p class="mb-0"><span data-i18n="home.solution.itemDesc">From onboarding to go-live, our team ensures a smooth deployment with clear workflows and measurable operational improvements.</span></p>
                                        </div>
                                        <div class="text-start mb-4">
                                            <a href="{{ route('contact') }}" class="btn btn-primary rounded-pill text-white py-3 px-5"><span data-i18n="home.common.moreDetails">More Details</span></a>
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
                            <p class="fs-4 text-uppercase text-primary"><span data-i18n="home.appointment.eyebrow">Get In Touch</span></p>
                            <h1 class="display-5 mb-4"><span data-i18n="home.appointment.title">Get Appointment</span></h1>
                            <form action="{{ route('contact') }}" method="GET">
                                <div class="row gy-3 gx-4">
                                    <div class="col-xl-6">
                                        <input type="text" name="name" class="form-control py-3 border-primary bg-transparent text-white" placeholder="First Name" data-i18n-placeholder="home.appointment.firstName">
                                    </div>
                                    <div class="col-xl-6">
                                        <input type="email" name="email" class="form-control py-3 border-primary bg-transparent text-white" placeholder="Email" data-i18n-placeholder="home.appointment.email">
                                    </div>
                                    <div class="col-xl-6">
                                        <input type="phone" name="phone" class="form-control py-3 border-primary bg-transparent" placeholder="Phone" data-i18n-placeholder="home.appointment.phone">
                                    </div>
                                    <div class="col-xl-6">
                                        <select class="form-select py-3 border-primary bg-transparent" aria-label="Default select example">
                                            <option selected data-i18n="home.appointment.gender">Your Gender</option>
                                            <option value="1" data-i18n="home.appointment.male">Male</option>
                                            <option value="2" data-i18n="home.appointment.female">FeMale</option>
                                            <option value="3" data-i18n="home.appointment.others">Others</option>
                                        </select>
                                    </div>
                                    <div class="col-xl-6">
                                        <input type="date" class="form-control py-3 border-primary bg-transparent">
                                    </div>
                                    <div class="col-xl-6">
                                        <select class="form-select py-3 border-primary bg-transparent" aria-label="Default select example">
                                            <option selected data-i18n="home.appointment.department">Department</option>
                                            <option value="1" data-i18n="home.features.card2.title">Smart Inventory Control</option>
                                            <option value="2" data-i18n="home.appointment.physical">Physical Helth</option>
                                            <option value="2" data-i18n="home.appointment.treatments">Treatments</option>
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <textarea class="form-control border-primary bg-transparent text-white" name="message" id="area-text" cols="30" rows="5" placeholder="Write Comments" data-i18n-placeholder="home.appointment.comments"></textarea>
                                    </div>
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary text-white w-100 py-3 px-5"><span data-i18n="home.appointment.submit">SUBMIT NOW</span></button>
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
                        <h5 class="modal-title" id="exampleModalLabel"><span data-i18n="home.video.title">Youtube Video</span></h5>
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
                <div class="text-center mt-4">
                    <a href="{{ route('clients.index') }}" class="btn btn-outline-primary rounded-pill px-4 py-2">Show More Clients</a>
                </div>
                @else
                    <p class="text-center text-muted" data-i18n="clients.empty">Clients will be published soon.</p>
                @endif
            </div>
        </section>
        <!-- Our Clients End -->


        <!-- Testimonial Start -->
        <!-- <div class="container-fluid testimonial py-5 wow zoomInDown" data-wow-delay="0.1s">
            <div class="container py-5">
                <div class="section-title mb-5">
                    <div class="sub-style">
                        <h4 class="sub-title text-white px-3 mb-0"><span data-i18n="home.testimonial.eyebrow">Testimonial</span></h4>
                    </div>
                    <h1 class="display-3 mb-4"><span data-i18n="home.testimonial.title">What Clients are Say</span></h1>
                </div>
                <div class="testimonial-carousel owl-carousel">
                    <div class="testimonial-item">
                        <div class="testimonial-inner p-5">
                            <div class="testimonial-inner-img mb-4">
                                <img src="{{ asset('img/testimonial-img.jpg') }}" class="img-fluid rounded-circle" alt="">
                            </div>
                            <p class="text-white fs-7"><span data-i18n="home.testimonial.quote">AQUA POS gave us a clear live view of sales and stock. Our branch teams now work faster with fewer manual errors and stronger daily control.</span>
                            </p>
                            <div class="text-center">
                                <h5 class="mb-2"><span data-i18n="home.testimonial.name">John Abraham</span></h5>
                                <p class="mb-2 text-white-50"><span data-i18n="home.testimonial.location">New York, USA</span></p>
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
                            <p class="text-white fs-7"><span data-i18n="home.testimonial.quote">AQUA POS gave us a clear live view of sales and stock. Our branch teams now work faster with fewer manual errors and stronger daily control.</span>
                            </p>
                            <div class="text-center">
                                <h5 class="mb-2"><span data-i18n="home.testimonial.name">John Abraham</span></h5>
                                <p class="mb-2 text-white-50"><span data-i18n="home.testimonial.location">New York, USA</span></p>
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
                            <p class="text-white fs-7"><span data-i18n="home.testimonial.quote">AQUA POS gave us a clear live view of sales and stock. Our branch teams now work faster with fewer manual errors and stronger daily control.</span>
                            </p>
                            <div class="text-center">
                                <h5 class="mb-2"><span data-i18n="home.testimonial.name">John Abraham</span></h5>
                                <p class="mb-2 text-white-50"><span data-i18n="home.testimonial.location">New York, USA</span></p>
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
        </div> -->
        <!-- Testimonial End -->


        <!-- Blog Start -->
        <div class="container-fluid blog py-5">
            <div class="container py-5">
                <div class="section-title mb-5 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="sub-style">
                        <h4 class="sub-title px-3 mb-0"><span data-i18n="home.blog.eyebrow">Our Blog</span></h4>
                    </div>
                    <h1 class="display-3 mb-3"><span data-i18n="home.blog.title">Real-Time Business Insights for Faster Decisions</span></h1>
                    <p class="mb-0"><span data-i18n="home.common.description">AQUA POS is a cloud-based POS and inventory management platform from Amman, Jordan, helping restaurants and retailers run faster with better control and full visibility.</span></p>
                    <div class="home-blog-actions d-flex flex-wrap gap-2 mt-4">
                        <a href="{{ route('blog') }}" class="btn btn-primary rounded-pill text-white px-4 py-2">
                            <i class="fas fa-blog me-2"></i><span>See More Blogs</span>
                        </a>
                        <a href="{{ route('news') }}" class="btn btn-outline-primary rounded-pill px-4 py-2">
                            <i class="far fa-newspaper me-2"></i><span>See More News</span>
                        </a>
                    </div>
                </div>

                <div class="row g-4 justify-content-center home-blog-grid">
                    @php($homePostsCollection = $homePosts ?? collect())
                    @if($homePostsCollection->isNotEmpty())
                        @foreach($homePostsCollection as $index => $post)
                            @php
                                $isNews = $post->type === 'news';
                                $postRoute = $isNews ? route('news.show', $post->slug) : route('blog.show', $post->slug);
                            @endphp
                            <div class="col-md-6 col-lg-6 col-xl-4 d-flex wow fadeInUp" data-wow-delay="{{ number_format((($index % 3) * 0.2) + 0.1, 1) }}s">
                                <div class="blog-item rounded h-100 d-flex flex-column">
                                    <div class="blog-img">
                                        <img src="{{ $post->cover_image_url }}" class="img-fluid w-100" alt="{{ $post->localized_title }}">
                                        <span class="home-post-badge {{ $isNews ? 'home-post-badge--news' : 'home-post-badge--blog' }}">
                                            <i class="fas {{ $isNews ? 'fa-broadcast-tower' : 'fa-pen-nib' }} me-1"></i>{{ strtoupper($post->type) }}
                                        </span>
                                    </div>
                                    <div class="blog-centent p-4 d-flex flex-column flex-grow-1">
                                        <div class="d-flex justify-content-between mb-4">
                                            <p class="mb-0 text-muted"><i class="fa fa-calendar-alt text-primary"></i> {{ $post->published_at?->format('d M Y') ?? $post->created_at?->format('d M Y') }}</p>
                                            <span class="text-muted"><i class="fa fa-folder-open text-primary"></i> {{ $post->category?->localized_name ?? 'General' }}</span>
                                        </div>
                                        <a href="{{ $postRoute }}" class="h4 d-block mb-3">{{ \Illuminate\Support\Str::limit($post->localized_title, 70) }}</a>
                                        <p class="my-4">{{ \Illuminate\Support\Str::limit($post->localized_excerpt ?: strip_tags($post->localized_content), 135) }}</p>
                                        <div class="mt-auto pt-2">
                                            <a href="{{ $postRoute }}" class="btn btn-primary rounded-pill text-white py-2 px-4 mb-1"><span data-i18n="home.common.readMore">Read More</span></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="col-12">
                            <div class="alert alert-info text-center mb-0" data-i18n="blog.noPosts">No posts found.</div>
                        </div>
                    @endif
                </div>
                <div class="text-center mt-4">
                    <a href="{{ route('blog') }}" class="btn btn-primary rounded-pill text-white px-4 py-2 me-2 mb-2">
                        <span>See All Insights</span>
                    </a>
                    <a href="{{ route('news') }}" class="btn btn-outline-primary rounded-pill px-4 py-2 mb-2">
                        <span>Latest News</span>
                    </a>
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
