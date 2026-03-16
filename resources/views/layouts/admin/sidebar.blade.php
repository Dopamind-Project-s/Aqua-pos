<aside class="left-sidebar">
    <div>
        <div class="brand-logo d-flex align-items-center justify-content-between px-3 py-2">
            <a href="{{ route('admin.dashboard') }}" class="text-nowrap logo-img d-flex align-items-center gap-2 text-decoration-none">
                @if($siteSetting?->primary_logo)
                    <img src="{{ Storage::url($siteSetting->primary_logo) }}" alt="{{ $siteSetting?->site_name ?: 'AQUA POS' }}" style="max-height: 38px; width: auto;">
                @else
                    <i class="ti ti-droplet text-primary fs-6"></i>
                @endif
                <span class="fw-bold text-dark">{{ $siteSetting?->site_name ?: 'AQUA POS' }}</span>
            </a>
            <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                <i class="ti ti-x fs-6"></i>
            </div>
        </div>

        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <li class="nav-small-cap"><span class="hide-menu">Admin</span></li>
                <li class="sidebar-item"><a class="sidebar-link" href="{{ route('admin.dashboard') }}"><i class="ti ti-layout-dashboard"></i><span class="hide-menu">Dashboard</span></a></li>
                <li class="sidebar-item"><a class="sidebar-link" href="{{ route('admin.categories.index') }}"><i class="ti ti-category"></i><span class="hide-menu">Categories</span></a></li>
                <li class="sidebar-item"><a class="sidebar-link" href="{{ route('admin.products.index') }}"><i class="ti ti-package"></i><span class="hide-menu">Products</span></a></li>
                <li class="sidebar-item"><a class="sidebar-link" href="{{ route('admin.posts.index') }}"><i class="ti ti-article"></i><span class="hide-menu">Posts</span></a></li>
                <li class="sidebar-item"><a class="sidebar-link" href="{{ route('admin.partners.index') }}"><i class="ti ti-hand-stop"></i><span class="hide-menu">Partners</span></a></li>
                <li class="sidebar-item"><a class="sidebar-link" href="{{ route('admin.clients.index') }}"><i class="ti ti-users-group"></i><span class="hide-menu">Clients</span></a></li>
                <li class="sidebar-item"><a class="sidebar-link" href="{{ route('admin.requests.index') }}"><i class="ti ti-mail"></i><span class="hide-menu">Requests</span></a></li>
                <li class="sidebar-item"><a class="sidebar-link" href="{{ route('admin.settings.edit') }}"><i class="ti ti-settings"></i><span class="hide-menu">Settings</span></a></li>
            </ul>
        </nav>
    </div>
</aside>
