<aside class="col-md-3 col-lg-2 bg-light border-end min-vh-100 p-3">
    <h5 class="mb-4">Admin Panel</h5>
    <ul class="nav flex-column gap-2">
        <li>
            <a href="{{ route('admin.index') }}" class="text-decoration-none">Dashboard</a>
        </li>
        <li>
            <a href="{{ route('admin.categories.index') }}">
                <i class="fas fa-layer-group"></i>
                <span>Categories</span>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.products.index') }}">
                <i class="fas fa-box"></i>
                <span>Products</span>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.settings.edit') }}">
                <i class="fas fa-gear"></i>
                <span>Settings</span>
            </a>
        </li>
    </ul>
</aside>
