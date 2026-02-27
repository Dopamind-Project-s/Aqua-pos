@php
    $now = now();
    $currentType = $type ?? 'blog';
    $currentCategoryName = $selectedCategoryName ?? ($post->category->name ?? 'All Categories');
    $categoryItems = $categories ?? collect();
@endphp

<div class="inner-mini-nav-wrap mb-4">
    <div class="inner-mini-nav d-flex flex-wrap align-items-center justify-content-center gap-2">
        <a href="{{ route('blog') }}" class="mini-nav-chip mini-nav-chip--switch {{ $currentType === 'blog' ? 'active' : '' }}" title="Blogs">
            <i class="fas fa-blog"></i>
            <span data-i18n="blog.nav.blogs">Blogs</span>
        </a>

        <a href="{{ route('news') }}" class="mini-nav-chip mini-nav-chip--switch {{ $currentType === 'news' ? 'active' : '' }}" title="News">
            <i class="far fa-newspaper"></i>
            <span data-i18n="blog.nav.news">News</span>
        </a>

        <div class="dropdown mini-nav-dropdown" title="Category">
            <button class="mini-nav-chip mini-nav-chip--category dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-folder-open"></i>
                <span data-i18n="blog.nav.category">Category</span>
                <strong>{{ $currentCategoryName }}</strong>
            </button>
            <div class="dropdown-menu dropdown-menu-end mini-nav-dropdown-menu">
                <h6 class="dropdown-header" data-i18n="blog.nav.allCategories">All Categories</h6>
                @forelse($categoryItems as $category)
                    <span class="dropdown-item-text d-flex justify-content-between align-items-center">
                        <span>{{ $category->name }}</span>
                        <small class="badge-soft">{{ $category->posts_count ?? 0 }}</small>
                    </span>
                @empty
                    <span class="dropdown-item-text text-muted" data-i18n="blog.nav.noCategories">No categories available</span>
                @endforelse
            </div>
        </div>

        <div class="mini-nav-chip mini-nav-chip--calendar" title="Calendar">
            <i class="far fa-calendar-alt"></i>
            <div class="calendar-meta">
                <small>{{ $now->format('d M Y') }}</small>
                <strong>{{ $now->format('l') }}</strong>
            </div>
        </div>

        <div class="mini-nav-chip mini-nav-chip--clock" title="Time">
            <i class="far fa-clock"></i>
            <div class="calendar-meta">
                <small data-i18n="blog.nav.time">Time</small>
                <strong>{{ $now->format('h:i A') }}</strong>
            </div>
        </div>
    </div>
</div>
