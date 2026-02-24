<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aqua POS Admin</title>

    <link href="{{ asset('dashboard/assets/css/styles.min.css') }}" rel="stylesheet">
</head>

<body>
@if (request()->routeIs('admin.categories.*') || request()->routeIs('admin.products.*') || request()->routeIs('admin.posts.*'))
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
         data-sidebar-position="fixed" data-header-position="fixed">

        <div class="app-topstrip bg-dark py-6 px-3 w-100 d-lg-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center justify-content-center gap-5 mb-2 mb-lg-0">
                <a class="d-flex justify-content-center" href="#">
                    <img src="{{ asset('dashboard/assets/images/logos/logo-wrappixel.svg') }}" alt="" width="150">
                </a>
            </div>

            <div class="d-lg-flex align-items-center gap-2">
                <h3 class="text-white mb-2 mb-lg-0 fs-5 text-center">Check Flexy Premium Version</h3>
                <div class="d-flex align-items-center justify-content-center gap-2">
                    <div class="dropdown d-flex">
                        <a class="btn btn-primary d-flex align-items-center gap-1" href="javascript:void(0)">
                            <i class="ti ti-shopping-cart fs-5"></i>
                            Buy Now
                            <i class="ti ti-chevron-down fs-5"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        @include('layouts.admin.sidebar')

        <div class="body-wrapper">
            @include('layouts.admin.header')

            <div class="body-wrapper-inner">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
@else
    @yield('content')
@endif

<script src="{{ asset('dashboard/assets/libs/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('dashboard/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('dashboard/assets/libs/simplebar/dist/simplebar.js') }}"></script>
<script src="{{ asset('dashboard/assets/js/sidebarmenu.js') }}"></script>
<script src="{{ asset('dashboard/assets/js/app.min.js') }}"></script>

@stack('scripts')

</body>
</html>
