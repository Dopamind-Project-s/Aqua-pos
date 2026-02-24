@extends('blogs.layout')

@section('content')
<section class="blog-hero">
    <div class="container">
        <span class="badge bg-light text-dark mb-3">Aqua POS Insights</span>
        <h1 class="display-5 fw-bold mb-3">{{ $type === 'blog' ? 'Blog' : 'News' }} for Restaurants & Retail Growth</h1>
        <p class="mb-0">تحليلات ونصائح عملية لتطوير المبيعات، إدارة المخزون، وتحسين تجربة العميل.</p>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="row g-4">
                    @forelse($posts as $post)
                        <div class="col-md-6">
                            <article class="card blog-card h-100">
                                <img class="thumb" src="{{ $post->cover_image ? Storage::url($post->cover_image) : asset('img/blog-1.jpg') }}" alt="{{ $post->title }}">
                                <div class="card-body d-flex flex-column">
                                    <div class="meta mb-2">{{ $post->published_at?->format('d M Y') ?? $post->created_at?->format('d M Y') }} • {{ $post->category?->name ?? 'General' }}</div>
                                    <h5 class="card-title mb-2">{{ $post->title }}</h5>
                                    <p class="text-muted mb-3">{{ \Illuminate\Support\Str::limit($post->excerpt ?: strip_tags($post->content), 120) }}</p>
                                    <a class="mt-auto btn btn-outline-primary rounded-pill" href="{{ $type === 'blog' ? route('blog.show', $post->slug) : route('news.show', $post->slug) }}">Read More</a>
                                </div>
                            </article>
                        </div>
                    @empty
                        <div class="col-12"><div class="alert alert-info">No {{ $type }} posts found.</div></div>
                    @endforelse
                </div>

                @if($posts->hasMorePages())
                    <div class="text-center mt-4">
                        <a href="{{ $posts->nextPageUrl() }}" class="btn btn-primary rounded-pill px-4">Load More</a>
                    </div>
                @endif
            </div>

            <div class="col-lg-4">
                <aside class="d-flex flex-column gap-4">
                    <div class="blog-sidebar-card">
                        <h6 class="fw-bold mb-3">Filter by Category</h6>
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
                        <h6 class="fw-bold mb-3">Latest {{ ucfirst($type) }}</h6>
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
