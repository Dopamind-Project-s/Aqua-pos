<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ ($siteSetting?->site_name ?: 'Aqua POS') . ' Admin' }}</title>

    <link href="{{ asset('dashboard/assets/css/styles.min.css') }}" rel="stylesheet">
    <style>
        .admin-topstrip {
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
        }
        .admin-topstrip__links a:hover {
            background: #edf4ff;
        }
        body.dark-mode .admin-topstrip {
            background: #101a2c;
            border-color: #253650;
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
