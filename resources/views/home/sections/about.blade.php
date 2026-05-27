@php
    $aboutCmsNamespace = $aboutCmsNamespace ?? 'home.about';
@endphp

<!-- About Start -->
@php($cmsPageKey = str_replace('.', '-', Route::currentRouteName() ?? trim(request()->path(), '/') ?: 'home'))
<div class="container-fluid about bg-light py-5" data-cms-section="about">
    <div class="container py-5">
        <div class="row g-5 align-items-center">
            <div class="col-lg-5 wow fadeInLeft" data-wow-delay="0.2s">
                <div class="about-img">
                    <div class="about-img-frame">
                        <img src="{{ dynamic_content($cmsPageKey . '.about.' . $aboutCmsNamespace . '.image_main.src', asset('img/about-1.jpg')) }}" class="img-fluid w-100 h-100 about-img-main" alt="Image" data-cms-key="{{ $aboutCmsNamespace }}.image_main">
                    </div>
                </div>
            </div>
            <div class="col-lg-7 wow fadeInRight" data-wow-delay="0.4s">
                <div class="section-title text-start mb-5">
                    <h4 class="sub-title sub-title--plain pe-3 mb-0"><span data-i18n="{{ $aboutCmsNamespace }}.eyebrow">About Us</span></h4>
                    <h1 class="display-3 mb-4"><span data-i18n="{{ $aboutCmsNamespace }}.title">Jordanian SaaS Team Building Better POS Operations.</span></h1>
                    <p class="mb-4"><span data-i18n="home.common.description">AQUA POS is a cloud-based POS and inventory management platform from Amman, Jordan, helping restaurants and retailers run faster with better control and full visibility.</span></p>
                    <div class="mb-4">
                        <p class="text-secondary"><i class="{{ dynamic_content($cmsPageKey . '.about.' . $aboutCmsNamespace . '.icon_1.value', 'fa fa-check text-primary me-2') }}" data-cms-key="{{ $aboutCmsNamespace }}.icon_1"></i><span data-i18n="{{ $aboutCmsNamespace }}.point1"> Built for restaurants and retail businesses.</span></p>
                        <p class="text-secondary"><i class="{{ dynamic_content($cmsPageKey . '.about.' . $aboutCmsNamespace . '.icon_2.value', 'fa fa-check text-primary me-2') }}" data-cms-key="{{ $aboutCmsNamespace }}.icon_2"></i><span data-i18n="{{ $aboutCmsNamespace }}.point2"> Reduce billing and stock errors across teams.</span></p>
                        <p class="text-secondary"><i class="{{ dynamic_content($cmsPageKey . '.about.' . $aboutCmsNamespace . '.icon_3.value', 'fa fa-check text-primary me-2') }}" data-cms-key="{{ $aboutCmsNamespace }}.icon_3"></i><span data-i18n="{{ $aboutCmsNamespace }}.point3"> Improve speed, control, and daily visibility.</span></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- About End -->
