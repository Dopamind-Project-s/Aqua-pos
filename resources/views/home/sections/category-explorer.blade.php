<!-- Category Explorer Start -->
<div class="container-fluid service py-5" data-cms-section="category-explorer">
    <div class="container py-5">
        <div class="section-title mb-5 wow fadeInUp" data-wow-delay="0.2s">
            <div class="sub-style">
                <h4 class="sub-title px-3 mb-0">CATEGORY SPOTLIGHT</h4>
            </div>
            <h1 class="display-3 mb-4">Explore Solutions by Business Category</h1>
            <p class="mb-0">Pick your business category to discover relevant products, client brands, and deployment-ready workflows.</p>
        </div>

        <div class="row g-4 justify-content-center">
            @if(collect($featuredCategories ?? [])->isNotEmpty())
                @foreach(collect($featuredCategories ?? []) as $index => $category)
                    <div class="col-md-6 col-lg-4 col-xl-3 d-flex wow fadeInUp" data-wow-delay="{{ number_format((($index % 4) * 0.2) + 0.1, 1) }}s">
                        <div class="service-item rounded h-100 d-flex flex-column">
                            <div class="service-img rounded-top">
                                <img src="{{ $category->image_url }}" class="img-fluid rounded-top w-100" alt="{{ $category->localized_name }}">
                            </div>
                            <div class="service-content rounded-bottom bg-light p-4 d-flex flex-column flex-grow-1">
                                <div class="service-content-inner d-flex flex-column h-100">
                                    <h5 class="mb-3">{{ $category->localized_name }}</h5>
                                    <p class="mb-2">{{ \Illuminate\Support\Str::limit($category->localized_description ?: 'Category tailored for scalable operations and better control.', 110) }}</p>
                                    <p class="small text-muted mb-4"><i class="fas fa-box-open me-1"></i>{{ $category->products_count }} products</p>
                                    <div class="mt-auto pt-2">
                                        <a href="{{ route('categories.show', $category->slug) }}" class="btn btn-primary rounded-pill text-white py-2 px-4 mb-2">Explore Category</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="col-12 text-center">
                    <p class="text-muted mb-3">No active categories available right now.</p>
                </div>
            @endif

            <div class="col-12 text-center wow fadeInUp" data-wow-delay="0.2s">
                <a class="btn btn-primary rounded-pill text-white py-3 px-5" href="{{ route('products') }}">Browse All Products</a>
            </div>
        </div>
    </div>
</div>
<!-- Category Explorer End -->
