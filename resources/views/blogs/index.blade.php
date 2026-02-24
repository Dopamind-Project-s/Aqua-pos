@extends('blogs.layout')

@section('blog-content')
<div class="container blog-slider-wrap mb-5">
    <div class="blog-slider owl-carousel">
        <div class="blog-slide-item">
            <img src="{{ asset('img/blog-1.jpg') }}" alt="Blog Slide">
            <div class="blog-slide-content">
                <div class="inner">
                    <span class="badge bg-primary mb-3">AQUA INSIGHTS</span>
                    <h2 class="display-5 fw-bold mb-3">{{ $type === 'blog' ? 'Professional Blog Articles' : 'Latest Industry News' }}</h2>
                    <p class="mb-0">محتوى احترافي يساعدك في تطوير المبيعات، تجربة العميل، وإدارة عمليات الفروع بكفاءة أعلى.</p>
                </div>
            </div>
        </div>
        <div class="blog-slide-item">
            <img src="{{ asset('img/blog-2.jpg') }}" alt="Blog Slide">
            <div class="blog-slide-content">
                <div class="inner">
                    <span class="badge bg-success mb-3">SMART RETAIL</span>
                    <h2 class="display-5 fw-bold mb-3">POS Strategies for Growth</h2>
                    <p class="mb-0">دروس عملية ونصائح تطبيقية من سوق التجزئة والمطاعم لرفع الأداء وتحسين الربحية.</p>
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
        @include('blogs.partials.inner-nav', ['type' => $type, 'selectedCategoryName' => $selectedCategoryName])
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="row g-4">
                    @forelse($posts as $post)
                        <div class="col-md-6">
                            <article class="card blog-card h-100">
                                <img class="thumb" src="{{ $post->cover_image ? Storage::url($post->cover_image) : asset('img/blog-3.jpg') }}" alt="{{ $post->title }}">
                                <div class="card-body d-flex flex-column">
                                    <div class="meta mb-2"><i class="far fa-calendar-alt me-1"></i>{{ $post->published_at?->format('d M Y') ?? $post->created_at?->format('d M Y') }} <span class="mx-1">•</span> <i class="fas fa-folder-open me-1"></i>{{ $post->category?->name ?? 'General' }}</div>
                                    <h5 class="card-title mb-2">{{ $post->title }}</h5>
                                    <p class="text-muted mb-3">{{ \Illuminate\Support\Str::limit($post->excerpt ?: strip_tags($post->content), 120) }}</p>
                                    <a class="mt-auto btn btn-outline-primary rounded-pill" href="{{ $type === 'blog' ? route('blog.show', $post->slug) : route('news.show', $post->slug) }}"><i class="fas fa-arrow-right me-2"></i>Read More</a>
                                </div>
                            </article>
                        </div>
                    @empty
                        <div class="col-12"><div class="alert alert-info">No {{ $type }} posts found.</div></div>
                    @endforelse
                </div>

                @if($posts->hasMorePages())
                    <div class="text-center mt-4">
                        <a href="{{ $posts->nextPageUrl() }}" class="btn btn-primary rounded-pill px-4"><i class="fas fa-sync-alt me-2"></i>Load More</a>
                    </div>
                @endif
            </div>

            <div class="col-lg-4">
                <aside class="d-flex flex-column gap-4">
                    <div class="blog-sidebar-card">
                        <h6 class="fw-bold mb-3"><i class="fas fa-filter me-2"></i>Filter by Category</h6>
                        <a href="{{ $type === 'blog' ? route('blog') : route('news') }}" class="d-flex justify-content-between text-decoration-none mb-2 {{ $selectedCategory === '' ? 'fw-bold text-primary' : 'text-dark' }}">
                            <span>All Categories</span>
                        </a>
                        @foreach($categories as $category)
                            <a href="{{ ($type === 'blog' ? route('blog') : route('news')) . '?category=' . $category->slug }}" class="d-flex justify-content-between text-decoration-none mb-2 {{ $selectedCategory === $category->slug ? 'fw-bold text-primary' : 'text-dark' }}">
                                <span>{{ $category->name }}</span>
                                <span class="badge-soft">{{ $category->posts_count }}</span>
                            </a>
                        @endforeach
                    </div>

                    <div class="blog-sidebar-card">
                        <h6 class="fw-bold mb-3"><i class="far fa-newspaper me-2"></i>Latest {{ ucfirst($type) }}</h6>
                        @foreach($latestPosts as $latest)
                            <a class="d-block text-decoration-none mb-3" href="{{ $type === 'blog' ? route('blog.show', $latest->slug) : route('news.show', $latest->slug) }}">
                                <div class="fw-semibold text-dark">{{ \Illuminate\Support\Str::limit($latest->title, 70) }}</div>
                                <small class="text-muted">{{ $latest->published_at?->format('d M Y') ?? $latest->created_at?->format('d M Y') }}</small>
                            </a>
                        @endforeach
                    </div>
                </aside>
            </div>
        </div>
    </div>
</section>
@endsection
