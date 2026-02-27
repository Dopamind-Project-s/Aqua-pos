@extends('blogs.layout')

@section('blog-content')
<div class="container blog-slider-wrap">
    <div class="blog-slider-shell">
    <div class="blog-slider owl-carousel">
        <div class="blog-slide-item">
            <img src="{{ asset('img/blog-1.jpg') }}" alt="Blog Slide">
            <div class="blog-slide-content">
                <div class="inner">
                    <span class="blog-hero-badge blog-hero-badge--primary mb-3"><i class="fas fa-sparkles"></i><span data-i18n="blog.hero.badge1">AQUA INSIGHTS</span></span>
                    <h2 class="display-5 fw-bold mb-3">
                        @if($type === 'blog')
                            <span data-i18n="blog.hero.titleBlog">Professional Blog Articles</span>
                        @else
                            <span data-i18n="blog.hero.titleNews">Latest Industry News</span>
                        @endif
                    </h2>
                    <p class="mb-0"><span data-i18n="blog.hero.desc1">Professional content that helps you improve sales, customer experience, and branch operations efficiently.</span></p>
                </div>
            </div>
        </div>
        <div class="blog-slide-item">
            <img src="{{ asset('img/blog-2.jpg') }}" alt="Blog Slide">
            <div class="blog-slide-content">
                <div class="inner">
                    <span class="blog-hero-badge blog-hero-badge--success mb-3"><i class="fas fa-bolt"></i><span data-i18n="blog.hero.badge2">SMART RETAIL</span></span>
                    <h2 class="display-5 fw-bold mb-3"><span data-i18n="blog.hero.title2">POS Strategies for Growth</span></h2>
                    <p class="mb-0"><span data-i18n="blog.hero.desc2">Practical lessons and proven tactics from retail and restaurant operations to improve performance and profitability.</span></p>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>

<section>
    <div class="container">
        @php
            $selectedCategoryName = $categories->firstWhere('slug', $selectedCategory)?->name ?? 'All Categories';
        @endphp
        @include('blogs.partials.inner-nav', ['type' => $type, 'selectedCategoryName' => $selectedCategoryName, 'categories' => $categories])
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="row g-4">
                    @forelse($posts as $post)
                        <div class="col-md-6">
                            <article class="card blog-card h-100">
                                @if($post->cover_image)
                                    <img class="thumb" src="{{ Storage::url($post->cover_image) }}" alt="{{ $post->title }}">
                                @else
                                    <div class="thumb thumb--placeholder" role="img" aria-label="Default post image">
                                        <i class="far fa-image"></i>
                                        <span data-i18n="blog.defaultImage">No image available</span>
                                    </div>
                                @endif
                                <div class="card-body d-flex flex-column">
                                    <div class="meta mb-2"><i class="far fa-calendar-alt me-1"></i>{{ $post->published_at?->format('d M Y') ?? $post->created_at?->format('d M Y') }} <span class="mx-1">•</span> <i class="fas fa-folder-open me-1"></i>{{ $post->category?->name ?? 'General' }}</div>
                                    <h5 class="card-title mb-2">{{ $post->title }}</h5>
                                    <p class="text-muted mb-3">{{ \Illuminate\Support\Str::limit($post->excerpt ?: strip_tags($post->content), 120) }}</p>
                                    <a class="mt-auto btn btn-outline-primary rounded-pill" href="{{ $type === 'blog' ? route('blog.show', $post->slug) : route('news.show', $post->slug) }}"><i class="fas fa-arrow-right me-2"></i><span data-i18n="blog.readMore">Read More</span></a>
                                </div>
                            </article>
                        </div>
                    @empty
                        <div class="col-12"><div class="alert alert-info"><span data-i18n="blog.noPosts">No posts found.</span></div></div>
                    @endforelse
                </div>

                @if($posts->hasMorePages())
                    <div class="text-center mt-4">
                        <a href="{{ $posts->nextPageUrl() }}" class="btn btn-primary rounded-pill px-4"><i class="fas fa-sync-alt me-2"></i><span data-i18n="blog.loadMore">Load More</span></a>
                    </div>
                @endif
            </div>

            <div class="col-lg-4">
                <aside class="d-flex flex-column gap-4">
                    <div class="blog-sidebar-card">
                        <h6 class="fw-bold mb-3"><i class="fas fa-filter me-2"></i><span data-i18n="blog.filterByCategory">Filter by Category</span></h6>
                        <a href="{{ $type === 'blog' ? route('blog') : route('news') }}" class="d-flex justify-content-between text-decoration-none mb-2 {{ $selectedCategory === '' ? 'fw-bold text-primary' : 'text-dark' }}">
                            <span data-i18n="blog.nav.allCategories">All Categories</span>
                        </a>
                        @foreach($categories as $category)
                            <a href="{{ ($type === 'blog' ? route('blog') : route('news')) . '?category=' . $category->slug }}" class="d-flex justify-content-between text-decoration-none mb-2 {{ $selectedCategory === $category->slug ? 'fw-bold text-primary' : 'text-dark' }}">
                                <span>{{ $category->name }}</span>
                                <span class="badge-soft">{{ $category->posts_count }}</span>
                            </a>
                        @endforeach
                    </div>

                    <div class="blog-sidebar-card">
                        <h6 class="fw-bold mb-3"><i class="far fa-newspaper me-2"></i><span data-i18n="blog.latest">Latest Posts</span></h6>
                        @foreach($latestPosts as $latest)
                            <a class="d-flex gap-2 text-decoration-none mb-3" href="{{ $type === 'blog' ? route('blog.show', $latest->slug) : route('news.show', $latest->slug) }}">
                                @if($latest->cover_image)
                                    <img class="sidebar-thumb" src="{{ Storage::url($latest->cover_image) }}" alt="{{ $latest->title }}">
                                @else
                                    <span class="sidebar-thumb sidebar-thumb--placeholder" aria-hidden="true"><i class="far fa-image"></i></span>
                                @endif
                                <span>
                                    <span class="fw-semibold text-dark d-block">{{ \Illuminate\Support\Str::limit($latest->title, 70) }}</span>
                                    <small class="text-muted">{{ $latest->published_at?->format('d M Y') ?? $latest->created_at?->format('d M Y') }}</small>
                                </span>
                            </a>
                        @endforeach
                    </div>
                </aside>
            </div>
        </div>
    </div>
</section>
@endsection
