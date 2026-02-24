<nav class="navbar navbar-expand-lg blogs-nav py-3 sticky-top">
    <div class="container">
        <a href="{{ route('home') }}" class="navbar-brand fw-bold">AQUA POS</a>
        <button class="navbar-toggler bg-white" type="button" data-bs-toggle="collapse" data-bs-target="#blogsNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="blogsNavbar">
            <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-2">
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('blog') || request()->routeIs('blog.show') ? 'active fw-bold' : '' }}" href="{{ route('blog') }}">Blogs</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('news') || request()->routeIs('news.show') ? 'active fw-bold' : '' }}" href="{{ route('news') }}">News</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('products') }}">Products</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('contact') }}">Contact</a></li>
            </ul>
        </div>
    </div>
</nav>
