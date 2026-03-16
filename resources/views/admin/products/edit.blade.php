@extends('layouts.admin')

@section('content')
@include('admin.partials.flash-messages')
<div class="card">
    <div class="card-body">
        <h4 class="card-title mb-1">Edit Product</h4>
        <p class="text-muted mb-3">English fields are treated as default automatically.</p>

        <form method="POST" action="{{ route('admin.products.update', $product->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row g-3">
                <div class="col-md-4"><label class="form-label">Category</label><select name="category_id" class="form-select @error('category_id') is-invalid @enderror" required><option value="">Select category</option>@foreach($categories as $category)<option value="{{ $category->id }}" @selected(old('category_id',$product->category_id)==$category->id)>{{ $category->localized_name }}</option>@endforeach</select>@error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                <div class="col-md-4"><label class="form-label">Slug</label><input name="slug" class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug',$product->slug) }}" required>@error('slug')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                <div class="col-md-4"><label class="form-label">Sort Order</label><input type="number" name="sort_order" min="0" class="form-control @error('sort_order') is-invalid @enderror" value="{{ old('sort_order',$product->sort_order) }}">@error('sort_order')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>

                <div class="col-md-6"><label class="form-label">Name (AR)</label><input name="name_ar" class="form-control" value="{{ old('name_ar',$product->name_ar) }}"></div>
                <div class="col-md-6"><label class="form-label">Name (EN - Default)</label><input name="name_en" class="form-control @error('name_en') is-invalid @enderror" value="{{ old('name_en',$product->name_en) }}" required>@error('name_en')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>

                <div class="col-md-6"><label class="form-label">Tagline (AR)</label><input name="tagline_ar" class="form-control" value="{{ old('tagline_ar',$product->tagline_ar) }}"></div>
                <div class="col-md-6"><label class="form-label">Tagline (EN - Default)</label><input name="tagline_en" class="form-control" value="{{ old('tagline_en',$product->tagline_en) }}"></div>

                <div class="col-md-6"><label class="form-label">Short Description (AR)</label><input name="short_description_ar" class="form-control" value="{{ old('short_description_ar',$product->short_description_ar) }}"></div>
                <div class="col-md-6"><label class="form-label">Short Description (EN - Default)</label><input name="short_description_en" class="form-control" value="{{ old('short_description_en',$product->short_description_en) }}"></div>

                <div class="col-md-4"><label class="form-label">Price</label><input type="number" step="0.01" name="price" class="form-control" value="{{ old('price',$product->price) }}"></div>
                <div class="col-md-4"><label class="form-label">Price Note</label><input name="price_note" class="form-control" value="{{ old('price_note',$product->price_note) }}"></div>
                <div class="col-md-4"><label class="form-label">Main Image</label><input type="file" name="image" accept="image/*" class="form-control @error('image') is-invalid @enderror">@error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>

                <div class="col-12"><img src="{{ $product->image ? Storage::url($product->image) : asset('img/service-1.jpg') }}" alt="{{ $product->localized_name }}" class="rounded border" style="width: 60px; height: 60px; object-fit: cover;"></div>

                <div class="col-12">
                    <label class="form-label">Add Gallery Images</label>
                    <input type="file" name="gallery_images[]" multiple accept="image/*" class="form-control @error('gallery_images') is-invalid @enderror @error('gallery_images.*') is-invalid @enderror">
                    @error('gallery_images')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    @error('gallery_images.*')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    <small class="text-muted">Upload additional product images. You can update sort order and alt text below.</small>
                </div>

                @if($product->images->isNotEmpty())
                    <div class="col-12">
                        <div class="border rounded p-3">
                            <h6 class="mb-3">Existing Gallery</h6>
                            <div class="row g-3">
                                @foreach($product->images as $image)
                                    <div class="col-md-6 col-xl-4">
                                        <div class="border rounded p-2 h-100">
                                            <img src="{{ Storage::url($image->image) }}" alt="{{ $image->alt ?: $product->localized_name }}" class="rounded border mb-2" style="width: 100%; height: 140px; object-fit: cover;">
                                            <label class="form-label mb-1">Alt Text</label>
                                            <input type="text" class="form-control form-control-sm mb-2" name="existing_alt[{{ $image->id }}]" value="{{ old('existing_alt.'.$image->id, $image->alt) }}" placeholder="Optional alt text">

                                            <label class="form-label mb-1">Sort Order</label>
                                            <input type="number" min="0" class="form-control form-control-sm mb-2" name="existing_sort[{{ $image->id }}]" value="{{ old('existing_sort.'.$image->id, $image->sort_order) }}">

                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="{{ $image->id }}" id="delete_image_{{ $image->id }}" name="delete_images[]">
                                                <label class="form-check-label text-danger" for="delete_image_{{ $image->id }}">Delete this image</label>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                <div class="col-md-6"><label class="form-label">Description (AR)</label><textarea name="description_ar" class="form-control" rows="3">{{ old('description_ar',$product->description_ar) }}</textarea></div>
                <div class="col-md-6"><label class="form-label">Description (EN - Default)</label><textarea name="description_en" class="form-control" rows="3">{{ old('description_en',$product->description_en) }}</textarea></div>

                <div class="col-md-12"><label class="form-label">Key Features (one per line)</label><textarea name="key_features" class="form-control" rows="3">{{ old('key_features', implode(PHP_EOL, $product->key_features ?? [])) }}</textarea></div>
                <div class="col-md-6"><label class="form-label">Use Cases (AR)</label><textarea name="use_cases_ar" class="form-control" rows="2">{{ old('use_cases_ar',$product->use_cases_ar) }}</textarea></div>
                <div class="col-md-6"><label class="form-label">Use Cases (EN - Default)</label><textarea name="use_cases_en" class="form-control" rows="2">{{ old('use_cases_en',$product->use_cases_en) }}</textarea></div>
            </div>

            <div class="form-check mt-3"><input class="form-check-input" type="checkbox" name="is_featured" value="1" id="is_featured" @checked(old('is_featured',$product->is_featured))><label class="form-check-label" for="is_featured">Featured</label></div>
            <div class="form-check mb-3"><input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active" @checked(old('is_active',$product->is_active))><label class="form-check-label" for="is_active">Active</label></div>
            <button class="btn btn-primary" type="submit">Update</button>
            <a href="{{ route('admin.products.index') }}" class="btn btn-outline-primary">Cancel</a>
        </form>
    </div>
</div>
@endsection
