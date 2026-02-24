@extends('blogs.layout')

@section('content')
<section class="blog-hero">
    <div class="container">
        <span class="badge bg-light text-dark mb-3">{{ strtoupper($type) }}</span>
        <h1 class="display-6 fw-bold mb-3">{{ $post->title }}</h1>
        <p class="mb-0">{{ $post->published_at?->format('d M Y') ?? $post->created_at?->format('d M Y') }} • {{ $post->category?->name ?? 'General' }} • {{ $post->author?->name ?? 'Aqua Team' }}</p>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-8">
                <article class="article-shell">
                    <img class="w-100 rounded-3 mb-4" style="max-height:420px;object-fit:cover" src="{{ $post->cover_image ? Storage::url($post->cover_image) : asset('img/blog-2.jpg') }}" alt="{{ $post->title }}">
                    @if($post->excerpt)
                        <p class="lead">{{ $post->excerpt }}</p>
                    @endif
                    <div class="article-content">{!! nl2br(e($post->content)) !!}</div>
                </article>
            </div>

            <div class="col-lg-4">
                <aside class="d-flex flex-column gap-4">
                    <div class="blog-sidebar-card">
                        <h6 class="fw-bold mb-3">Categories</h6>
                        @foreach($categories as $category)
                            <a href="{{ ($type === 'blog' ? route('blog') : route('news')) . '?category=' . $category->slug }}" class="d-flex justify-content-between text-decoration-none mb-2 text-dark">
                                <span>{{ $category->name }}</span>
                                <span class="badge-soft">{{ $category->posts_count }}</span>
                            </a>
                        @endforeach
                    </div>

                    <div class="blog-sidebar-card">
                        <h6 class="fw-bold mb-3">Similar {{ ucfirst($type) }}</h6>
                        @foreach($relatedPosts as $related)
                            <a class="d-block text-decoration-none mb-3" href="{{ $type === 'blog' ? route('blog.show', $related->slug) : route('news.show', $related->slug) }}">
                                <div class="fw-semibold text-dark">{{ \Illuminate\Support\Str::limit($related->title, 72) }}</div>
                                <small class="text-muted">{{ $related->published_at?->format('d M Y') ?? $related->created_at?->format('d M Y') }}</small>
                            </a>
                        @endforeach
                    </div>

                    <div class="blog-sidebar-card">
                        <h6 class="fw-bold mb-3">Latest</h6>
                        @foreach($latestPosts as $latest)
                            <a class="d-block text-decoration-none mb-3" href="{{ $type === 'blog' ? route('blog.show', $latest->slug) : route('news.show', $latest->slug) }}">
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
