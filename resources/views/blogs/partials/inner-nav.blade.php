@php
    $now = now();
    $currentType = $type ?? 'blog';
    $currentCategoryName = $selectedCategoryName ?? ($post->category->name ?? 'All Categories');
@endphp

<div class="inner-mini-nav-wrap mb-4">
    <div class="inner-mini-nav d-flex flex-wrap align-items-center justify-content-center gap-2">
        <a href="{{ route('blog') }}" class="mini-nav-chip {{ $currentType === 'blog' ? 'active' : '' }}" title="Blogs">
            <i class="fas fa-blog"></i>
            <span>Blogs</span>
        </a>

        <a href="{{ route('news') }}" class="mini-nav-chip {{ $currentType === 'news' ? 'active' : '' }}" title="News">
            <i class="far fa-newspaper"></i>
            <span>News</span>
        </a>

        <span class="mini-nav-chip" title="Category">
            <i class="fas fa-folder-open"></i>
            <span>{{ $currentCategoryName }}</span>
        </span>

        <span class="mini-nav-chip" title="Day">
            <i class="fas fa-calendar-week"></i>
            <span>{{ $now->format('l') }}</span>
        </span>

        <span class="mini-nav-chip" title="Date">
            <i class="far fa-calendar-alt"></i>
            <span>{{ $now->format('d M Y') }}</span>
        </span>

        <span class="mini-nav-chip" title="Time">
            <i class="far fa-clock"></i>
            <span>{{ $now->format('h:i A') }}</span>
        </span>
    </div>
</div>
