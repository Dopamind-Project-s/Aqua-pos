<!--  Body Wrapper -->
<div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
  data-sidebar-position="fixed" data-header-position="fixed">

  <!--  App Topstrip -->
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

  @include('admin.partials.flexy-sidebar')

  <div class="body-wrapper">
    <header class="app-header">
      <nav class="navbar navbar-expand-lg navbar-light">
        <ul class="navbar-nav">
          <li class="nav-item d-block d-xl-none">
            <a class="nav-link sidebartoggler" id="headerCollapse" href="javascript:void(0)">
              <i class="ti ti-menu-2"></i>
            </a>
          </li>
        </ul>
        <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
          <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
            <li class="nav-item dropdown">
              <a class="nav-link" href="javascript:void(0)" id="drop2" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="{{ asset('dashboard/assets/images/profile/user-1.jpg') }}" alt="" width="35" height="35" class="rounded-circle">
              </a>
              <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
                <div class="message-body">
                  <a href="{{ route('admin.authentication-login') }}" class="btn btn-outline-primary mx-3 mt-2 d-block">Logout</a>
                </div>
              </div>
            </li>
          </ul>
        </div>
      </nav>
    </header>

    <div class="body-wrapper-inner">
      <div class="container-fluid">
