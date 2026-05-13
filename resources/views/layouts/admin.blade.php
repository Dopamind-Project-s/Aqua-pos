<!DOCTYPE html>
<html lang="{{ app_current_locale() }}" dir="{{ app_text_direction() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ ($siteSetting?->site_name ?: 'Aqua POS') . ' Admin' }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="{{ asset('dashboard/assets/css/styles.min.css') }}" rel="stylesheet">
    @if(app_is_rtl())
        <link href="{{ asset('css/rtl.css') }}" rel="stylesheet">
    @endif
    <style>
        :root {
            --admin-topstrip-offset: 84px;
        }

        .admin-topstrip {
            position: sticky;
            top: 0;
            z-index: 1040;
            border-bottom: 1px solid #e7edf7;
            background: linear-gradient(90deg, #f7faff 0%, #ffffff 100%);
        }

        .admin-topstrip__brand {
            font-weight: 700;
            color: #193b70;
        }

        .admin-topstrip__meta {
            font-size: .82rem;
            color: #6a7f9f;
        }

        .admin-topstrip__links a {
            border: 1px solid #d9e5f8;
            color: #1f4f97;
            background: #fff;
            border-radius: 999px;
            padding: 6px 12px;
            font-size: .78rem;
            font-weight: 600;
            text-decoration: none;
            white-space: nowrap;
        }

        .admin-topstrip__links a:hover {
            background: #edf4ff;
        }

        .left-sidebar {
            top: var(--admin-topstrip-offset);
            height: calc(100vh - var(--admin-topstrip-offset));
            z-index: 1031;
            border-top: 1px solid #eef2fa;
        }

        .left-sidebar .sidebar-nav {
            height: 100%;
            overflow: auto;
        }

        .body-wrapper .app-header {
            position: sticky;
            top: var(--admin-topstrip-offset);
            z-index: 1030;
            background: #fff;
            border-bottom: 1px solid #edf1f7;
        }

        .body-wrapper-inner {
            padding-top: 1rem;
        }

        .admin-header-actions {
            min-height: 70px;
        }

        @media (max-width: 1199.98px) {
            :root {
                --admin-topstrip-offset: 0px;
            }

            .admin-topstrip {
                position: static;
            }

            .left-sidebar {
                top: 0;
                height: 100%;
                border-top: 0;
            }

            .body-wrapper .app-header {
                top: 0;
            }
        }

        body.dark-mode .admin-topstrip {
            background: #101a2c;
            border-color: #253650;
        }

        body {
            font-family: 'Inter', 'Cairo', sans-serif;
            font-size: 14px;
        }

        [dir="rtl"] body {
            font-family: 'Cairo', 'Inter', sans-serif;
        }

        [dir="rtl"] .left-sidebar {
            right: 0;
            left: auto;
            border-right: 0;
            border-left: 1px solid var(--bs-border-color);
        }

        [dir="rtl"] .sidebar-link {
            text-align: right;
        }

        @media (min-width: 1200px) {
            [dir="rtl"] #main-wrapper[data-layout=vertical][data-sidebartype=full] .body-wrapper {
                margin-right: 270px;
                margin-left: 0;
            }
        }

        @media (max-width: 1199.98px) {
            [dir="rtl"] #main-wrapper[data-layout=vertical][data-sidebartype=full] .left-sidebar,
            [dir="rtl"] #main-wrapper[data-layout=vertical][data-sidebartype=mini-sidebar] .left-sidebar {
                right: -270px;
                left: auto;
            }

            [dir="rtl"] #main-wrapper[data-layout=vertical][data-sidebartype=full].show-sidebar .left-sidebar,
            [dir="rtl"] #main-wrapper[data-layout=vertical][data-sidebartype=mini-sidebar].show-sidebar .left-sidebar {
                right: 0;
                left: auto;
            }
        }
    </style>
</head>

<body>
<div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
     data-sidebar-position="fixed" data-header-position="fixed">

    <div class="admin-topstrip py-3 px-3 w-100 d-lg-flex align-items-center justify-content-between">
        <div>
            <div class="admin-topstrip__brand">{{ $siteSetting?->site_name ?: 'AQUA POS' }} · Admin Console</div>
            <div class="admin-topstrip__meta">Manage catalog, clients, requests, and website settings from one place.</div>
        </div>
        <div class="admin-topstrip__links d-flex flex-wrap gap-2 mt-2 mt-lg-0">
            <a href="{{ route('home') }}">View Website</a>
            <a href="{{ route('admin.requests.index') }}">Requests</a>
            <a href="{{ route('admin.settings.edit') }}">Settings</a>
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

<script src="{{ asset('dashboard/assets/libs/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('dashboard/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('dashboard/assets/libs/simplebar/dist/simplebar.js') }}"></script>
<script src="{{ asset('dashboard/assets/js/sidebarmenu.js') }}"></script>
<script src="{{ asset('dashboard/assets/js/app.min.js') }}"></script>

@stack('scripts')

</body>
</html>
