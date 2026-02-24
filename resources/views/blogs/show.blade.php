@extends('blogs.layout')

@section('blog-content')
<section class="mb-4">
    <div class="container">
        <div class="post-mini-nav d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('blog') }}" class="chip text-decoration-none"><i class="fas fa-blog"></i> Blog</a>
                <a href="{{ route('news') }}" class="chip text-decoration-none"><i class="far fa-newspaper"></i> News</a>
                <span class="chip"><i class="far fa-calendar-alt"></i> {{ $post->published_at?->format('d M Y') ?? $post->created_at?->format('d M Y') }}</span>
                <span class="chip"><i class="far fa-clock"></i> {{ $post->published_at?->format('h:i A') ?? $post->created_at?->format('h:i A') }}</span>
            </div>
            <div>
                <a href="{{ ($type === 'blog' ? route('blog') : route('news')) . ($post->category?->slug ? '?category=' . $post->category->slug : '') }}" class="chip text-decoration-none"><i class="fas fa-folder"></i> {{ $post->category?->name ?? 'General' }}</a>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-8">
                <article class="article-shell">
                    <div class="mb-3 d-flex align-items-center justify-content-between gap-2 flex-wrap">
                        <span class="badge bg-primary px-3 py-2">{{ strtoupper($type) }}</span>
                        <div class="social-share d-flex gap-2">
                            <a href="#" aria-label="Share on Facebook"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" aria-label="Share on Twitter"><i class="fab fa-twitter"></i></a>
                            <a href="#" aria-label="Share on LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                            <a href="#" aria-label="Share on WhatsApp"><i class="fab fa-whatsapp"></i></a>
                        </div>
                    </div>

                    <h1 class="display-6 fw-bold mb-3">{{ $post->title }}</h1>
                    <p class="text-muted mb-4"><i class="fas fa-user-edit me-2"></i>{{ $post->author?->name ?? 'Aqua Team' }}</p>

                    <img class="article-cover mb-4" src="{{ $post->cover_image ? Storage::url($post->cover_image) : asset('img/blog-2.jpg') }}" alt="{{ $post->title }}">

                    @if($post->excerpt)
                        <blockquote class="border-start border-4 border-primary ps-3 mb-4 text-dark fw-semibold">{{ $post->excerpt }}</blockquote>
                    @endif

                    <div class="article-content">{!! nl2br(e($post->content)) !!}</div>
                </article>
            </div>

            <div class="col-lg-4">
                <aside class="d-flex flex-column gap-4">
                    <div class="blog-sidebar-card">
                        <h6 class="fw-bold mb-3"><i class="fas fa-layer-group me-2"></i>Categories</h6>
                        @foreach($categories as $category)
                            <a href="{{ ($type === 'blog' ? route('blog') : route('news')) . '?category=' . $category->slug }}" class="d-flex justify-content-between text-decoration-none mb-2 text-dark">
                                <span>{{ $category->name }}</span>
                                <span class="badge-soft">{{ $category->posts_count }}</span>
                            </a>
                        @endforeach
                    </div>

                    <div class="blog-sidebar-card">
                        <h6 class="fw-bold mb-3"><i class="fas fa-th-large me-2"></i>Similar {{ ucfirst($type) }}</h6>
                        @foreach($relatedPosts as $related)
                            <a class="d-flex gap-2 text-decoration-none mb-3" href="{{ $type === 'blog' ? route('blog.show', $related->slug) : route('news.show', $related->slug) }}">
                                <img src="{{ $related->cover_image ? Storage::url($related->cover_image) : asset('img/blog-1.jpg') }}" alt="{{ $related->title }}" style="width:68px;height:68px;object-fit:cover;border-radius:10px;">
                                <div>
                                    <div class="fw-semibold text-dark">{{ \Illuminate\Support\Str::limit($related->title, 72) }}</div>
                                    <small class="text-muted">{{ $related->published_at?->format('d M Y') ?? $related->created_at?->format('d M Y') }}</small>
                                </div>
                            </a>
                        @endforeach
                    </div>

                    <div class="blog-sidebar-card">
                        <h6 class="fw-bold mb-3"><i class="fas fa-clock me-2"></i>Latest</h6>
                        @foreach($latestPosts as $latest)
                            <a class="d-flex gap-2 text-decoration-none mb-3" href="{{ $type === 'blog' ? route('blog.show', $latest->slug) : route('news.show', $latest->slug) }}">
                                <img src="{{ $latest->cover_image ? Storage::url($latest->cover_image) : asset('img/blog-3.jpg') }}" alt="{{ $latest->title }}" style="width:68px;height:68px;object-fit:cover;border-radius:10px;">
                                <div class="fw-semibold text-dark">{{ \Illuminate\Support\Str::limit($latest->title, 72) }}</div>
                            </a>
                        @endforeach
                    </div>
                </aside>
            </div>
        </div>
    </div>
</section>
@endsection
