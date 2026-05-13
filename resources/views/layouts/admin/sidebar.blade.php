<aside class="left-sidebar">
    <div class="h-100 d-flex flex-column">
        <div class="brand-logo d-flex align-items-center justify-content-between px-3 py-3">
            <a href="{{ route('admin.dashboard') }}" class="logo-img d-flex align-items-center gap-2 text-decoration-none">
                @if($siteSetting?->primary_logo)
                    <img src="{{ public_storage_url($siteSetting->primary_logo) }}" alt="{{ $siteSetting?->site_name ?: 'AQUA POS' }}" style="max-height: 38px; width: auto;">
                @else
                    <i class="ti ti-droplet text-primary fs-6"></i>
                @endif
                <span class="fw-bold text-dark text-truncate" style="max-width: 145px;">{{ $siteSetting?->site_name ?: 'AQUA POS' }}</span>
            </a>
            <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                <i class="ti ti-x fs-6"></i>
            </div>
        </div>

        <nav class="sidebar-nav px-2 pb-2">
            <ul id="sidebarnav">
                <li class="nav-small-cap"><span class="hide-menu">Overview</span></li>
                <li class="sidebar-item"><a class="sidebar-link" href="{{ route('admin.dashboard') }}"><i class="ti ti-layout-dashboard"></i><span class="hide-menu">Dashboard</span></a></li>
                <li class="sidebar-item"><a class="sidebar-link" href="{{ route('admin.requests.index') }}"><i class="ti ti-mail"></i><span class="hide-menu">Requests</span></a></li>

                <li class="nav-small-cap mt-2"><span class="hide-menu">Content</span></li>
                <li class="sidebar-item"><a class="sidebar-link" href="{{ route('admin.categories.index') }}"><i class="ti ti-category"></i><span class="hide-menu">Categories</span></a></li>
                <li class="sidebar-item"><a class="sidebar-link" href="{{ route('admin.products.index') }}"><i class="ti ti-package"></i><span class="hide-menu">Products</span></a></li>
                <li class="sidebar-item"><a class="sidebar-link" href="{{ route('admin.posts.index') }}"><i class="ti ti-article"></i><span class="hide-menu">Posts</span></a></li>

                <li class="nav-small-cap mt-2"><span class="hide-menu">Relations</span></li>
                <li class="sidebar-item"><a class="sidebar-link" href="{{ route('admin.partners.index') }}"><i class="ti ti-hand-stop"></i><span class="hide-menu">Partners</span></a></li>
                <li class="sidebar-item"><a class="sidebar-link" href="{{ route('admin.clients.index') }}"><i class="ti ti-users-group"></i><span class="hide-menu">Clients</span></a></li>
                <li class="sidebar-item"><a class="sidebar-link" href="{{ route('admin.team-members.index') }}"><i class="ti ti-users"></i><span class="hide-menu">Team Members</span></a></li>

                <li class="nav-small-cap mt-2"><span class="hide-menu">System</span></li>
                <li class="sidebar-item"><a class="sidebar-link" href="{{ route('admin.settings.edit') }}"><i class="ti ti-settings"></i><span class="hide-menu">Settings</span></a></li>
            </ul>
        </nav>
    </div>
</aside>
