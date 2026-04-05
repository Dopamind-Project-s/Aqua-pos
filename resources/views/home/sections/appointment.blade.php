        <!-- Book Appointment Start -->
        <div class="container-fluid appointment py-5" data-cms-section="appointment">
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
