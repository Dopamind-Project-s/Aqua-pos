        @php
            $cmsPageKey = str_replace('.', '-', Route::currentRouteName() ?? trim(request()->path(), '/') ?: 'home');
            $homeSolutionVideoSrc = dynamic_content(
                $cmsPageKey . '.appointment.solution_video.src',
                $siteSetting?->home_solution_video ? public_storage_url($siteSetting->home_solution_video, '') : ''
            );
            $homeSolutionVideoPoster = dynamic_content(
                $cmsPageKey . '.appointment.solution_video.poster',
                asset('img/video-img.jpg')
            );
        @endphp
        <!-- Solution Video Start -->
        <div class="container-fluid appointment py-5" data-cms-section="appointment">
            <div class="container py-5">
                <div class="row g-5 align-items-center">
                    <div class="col-lg-4 wow fadeInLeft" data-wow-delay="0.2">
                        <div class="section-title text-start">
                            <h1 class="display-4 mb-4"><span data-i18n="home.solution.title">Best Quality Services With Minimal Pain Rate</span></h1>
                            <p class="mb-4"><span data-i18n="home.common.description">AQUA POS is a cloud-based POS and inventory management platform from Amman, Jordan, helping restaurants and retailers run faster with better control and full visibility.</span></p>
                            <div class="row g-4">
                                <div class="col-12">
                                    <div class="d-flex flex-column h-100">
                                        <div class="mb-4">
                                            <h5 class="mb-3"><i class="fa fa-check text-primary me-2"></i><span data-i18n="home.solution.item1.title"> Body Relaxation</span></h5>
                                            <p class="mb-0"><span data-i18n="home.solution.item1.desc">From onboarding to go-live, our team ensures a smooth deployment with clear workflows and measurable operational improvements.</span></p>
                                        </div>
                                        <div class="mb-4">
                                            <h5 class="mb-3"><i class="fa fa-check text-primary me-2"></i><span data-i18n="home.solution.item2.title"> Body Relaxation</span></h5>
                                            <p class="mb-0"><span data-i18n="home.solution.item2.desc">From onboarding to go-live, our team ensures a smooth deployment with clear workflows and measurable operational improvements.</span></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8 wow fadeInRight" data-wow-delay="0.4s">
                        <div class="appointment-video">
                            <video class="appointment-video__media" controls preload="metadata" poster="{{ $homeSolutionVideoPoster }}" data-cms-key="solution_video">
                                @if($homeSolutionVideoSrc)
                                    <source src="{{ $homeSolutionVideoSrc }}">
                                @endif
                            </video>
                            @unless($homeSolutionVideoSrc)
                                <span class="appointment-video__placeholder">Upload video</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Solution Video End -->
