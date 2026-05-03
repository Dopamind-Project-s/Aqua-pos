@extends('blogs.layout')

@section('blog-content')
<section class="mb-4">
    <div class="container">
        <div class="article-page-head mb-4">
            <span class="article-page-head__eyebrow mb-2"><i class="far fa-newspaper"></i>{{ strtoupper($type) }}</span>
            <h1 class="h2 fw-bold mb-2">{{ $post->localized_title }}</h1>
            <p class="mb-0 text-muted"><i class="far fa-calendar-alt me-2"></i>{{ $post->published_at?->format('d M Y') ?? $post->created_at?->format('d M Y') }} <span class="mx-2">•</span><i class="fas fa-folder-open me-2"></i>{{ $post->category?->localized_name ?? 'General' }}</p>
        </div>

        @include('blogs.partials.inner-nav', ['type' => $type, 'post' => $post, 'categories' => $categories])

        <div class="row g-4">
            <div class="col-lg-8">
                <article class="article-shell">
                    <div class="mb-4 d-flex align-items-center justify-content-between gap-2 flex-wrap">
                        <p class="text-muted mb-0"><i class="fas fa-user-edit me-2"></i>{{ $post->author?->name ?? 'Aqua Team' }}</p>
                        <div class="social-share d-flex gap-2">
                            <a href="#" class="social-facebook" aria-label="Share on Facebook"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class="social-twitter" aria-label="Share on Twitter"><i class="fab fa-twitter"></i></a>
                            <a href="#" class="social-linkedin" aria-label="Share on LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                            <a href="#" class="social-whatsapp" aria-label="Share on WhatsApp"><i class="fab fa-whatsapp"></i></a>
                        </div>
                    </div>

                    @if($post->cover_image)
                        <img class="article-cover mb-4" src="{{ public_storage_url($post->cover_image) }}" alt="{{ $post->localized_title }}">
                    @else
                        <div class="article-cover article-cover--placeholder mb-4" role="img" aria-label="Default post image">
                            <i class="far fa-image"></i>
                            <span data-i18n="blog.defaultImage">No image available</span>
                        </div>
                    @endif

                    @if($post->localized_excerpt)
                        <blockquote class="border-start border-4 border-primary ps-3 mb-4 text-dark fw-semibold">{{ $post->localized_excerpt }}</blockquote>
                    @endif

                    <div class="article-content">{!! nl2br(e($post->localized_content)) !!}</div>
                </article>
            </div>

            <div class="col-lg-4">
                <aside class="d-flex flex-column gap-4">
                    <div class="blog-sidebar-card">
                        <h6 class="fw-bold mb-3"><i class="fas fa-layer-group me-2"></i><span data-i18n="blog.nav.category">Category</span></h6>
                        @foreach($categories as $category)
                            <a href="{{ ($type === 'blog' ? route('blog') : route('news')) . '?category=' . $category->slug }}" class="d-flex justify-content-between text-decoration-none mb-2 text-dark">
                                <span>{{ $category->localized_name }}</span>
                                <span class="badge-soft">{{ $category->posts_count }}</span>
                            </a>
                        @endforeach
                    </div>

                    <div class="blog-sidebar-card">
                        <h6 class="fw-bold mb-3"><i class="fas fa-th-large me-2"></i><span data-i18n="blog.related">Similar Posts</span></h6>
                        @foreach($relatedPosts as $related)
                            <a class="d-flex gap-2 text-decoration-none mb-3" href="{{ $type === 'blog' ? route('blog.show', $related->slug) : route('news.show', $related->slug) }}">
                                @if($related->cover_image)
                                    <img class="sidebar-thumb" src="{{ public_storage_url($related->cover_image) }}" alt="{{ $related->localized_title }}">
                                @else
                                    <span class="sidebar-thumb sidebar-thumb--placeholder" aria-hidden="true"><i class="far fa-image"></i></span>
                                @endif
                                <div>
                                    <div class="fw-semibold text-dark">{{ \Illuminate\Support\Str::limit($related->localized_title, 72) }}</div>
                                    <small class="text-muted">{{ $related->published_at?->format('d M Y') ?? $related->created_at?->format('d M Y') }}</small>
                                </div>
                            </a>
                        @endforeach
                    </div>

                    <div class="blog-sidebar-card">
                        <h6 class="fw-bold mb-3"><i class="fas fa-clock me-2"></i><span data-i18n="blog.latest">Latest Posts</span></h6>
                        @foreach($latestPosts as $latest)
                            <a class="d-flex gap-2 text-decoration-none mb-3" href="{{ $type === 'blog' ? route('blog.show', $latest->slug) : route('news.show', $latest->slug) }}">
                                @if($latest->cover_image)
                                    <img class="sidebar-thumb" src="{{ public_storage_url($latest->cover_image) }}" alt="{{ $latest->localized_title }}">
                                @else
                                    <span class="sidebar-thumb sidebar-thumb--placeholder" aria-hidden="true"><i class="far fa-image"></i></span>
                                @endif
                                <div class="fw-semibold text-dark">{{ \Illuminate\Support\Str::limit($latest->localized_title, 72) }}</div>
                            </a>
                        @endforeach
                    </div>
                </aside>
            </div>
        </div>
    </div>
</section>
@endsection
