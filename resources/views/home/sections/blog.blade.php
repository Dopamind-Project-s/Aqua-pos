        <!-- Blog Start -->
        <div class="container-fluid blog py-5" data-cms-section="blog">
            <div class="container py-5">
                <div class="section-title mb-5 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="sub-style">
                        <h4 class="sub-title px-3 mb-0"><span data-i18n="home.blog.eyebrow">Our Blog</span></h4>
                    </div>
                    <h1 class="display-3 mb-3"><span data-i18n="home.blog.title">Real-Time Business Insights for Faster Decisions</span></h1>
                    <p class="mb-0"><span data-i18n="home.common.description">AQUA POS is a cloud-based POS and inventory management platform from Amman, Jordan, helping restaurants and retailers run faster with better control and full visibility.</span></p>
                    <div class="home-blog-actions d-flex flex-wrap gap-2 mt-4">
                        <a href="{{ route('blog') }}" class="btn btn-primary rounded-pill text-white px-4 py-2">
                            <i class="fas fa-blog me-2"></i><span>See More Blogs</span>
                        </a>
                        <a href="{{ route('news') }}" class="btn btn-outline-primary rounded-pill px-4 py-2">
                            <i class="far fa-newspaper me-2"></i><span>See More News</span>
                        </a>
                    </div>
                </div>

                <div class="row g-4 justify-content-center home-blog-grid">
                    @if(collect($homePosts ?? [])->isNotEmpty())
                        @foreach(collect($homePosts ?? []) as $index => $post)
                            @php
                                $isNews = $post->type === 'news';
                                $postRoute = $isNews ? route('news.show', $post->slug) : route('blog.show', $post->slug);
                            @endphp
                            <div class="col-md-6 col-lg-6 col-xl-4 d-flex wow fadeInUp" data-wow-delay="{{ number_format((($index % 3) * 0.2) + 0.1, 1) }}s">
                                <div class="blog-item rounded h-100 d-flex flex-column">
                                    <div class="blog-img">
                                        <img src="{{ $post->cover_image_url }}" class="img-fluid w-100" alt="{{ $post->localized_title }}">
                                        <span class="home-post-badge {{ $isNews ? 'home-post-badge--news' : 'home-post-badge--blog' }}">
                                            <i class="fas {{ $isNews ? 'fa-broadcast-tower' : 'fa-pen-nib' }} me-1"></i>{{ strtoupper($post->type) }}
                                        </span>
                                    </div>
                                    <div class="blog-centent p-4 d-flex flex-column flex-grow-1">
                                        <div class="d-flex justify-content-between mb-4">
                                            <p class="mb-0 text-muted"><i class="fa fa-calendar-alt text-primary"></i> {{ $post->published_at?->format('d M Y') ?? $post->created_at?->format('d M Y') }}</p>
                                            <span class="text-muted"><i class="fa fa-folder-open text-primary"></i> {{ $post->category?->localized_name ?? 'General' }}</span>
                                        </div>
                                        <a href="{{ $postRoute }}" class="h4 d-block mb-3">{{ \Illuminate\Support\Str::limit($post->localized_title, 70) }}</a>
                                        <p class="my-4">{{ \Illuminate\Support\Str::limit($post->localized_excerpt ?: strip_tags($post->localized_content), 135) }}</p>
                                        <div class="mt-auto pt-2">
                                            <a href="{{ $postRoute }}" class="btn btn-primary rounded-pill text-white py-2 px-4 mb-1"><span data-i18n="home.common.readMore">Read More</span></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="col-12">
                            <div class="alert alert-info text-center mb-0" data-i18n="blog.noPosts">No posts found.</div>
                        </div>
                    @endif
                </div>
                <div class="text-center mt-4">
                    <a href="{{ route('blog') }}" class="btn btn-primary rounded-pill text-white px-4 py-2 me-2 mb-2">
                        <span>See All Insights</span>
                    </a>
                    <a href="{{ route('news') }}" class="btn btn-outline-primary rounded-pill px-4 py-2 mb-2">
                        <span>Latest News</span>
                    </a>
                </div>
            </div>
        </div>
        <!-- Blog End -->
