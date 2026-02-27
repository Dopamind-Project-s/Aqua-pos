@extends('layouts.admin')

@section('content')
@include('admin.partials.flash-messages')
<div class="card"><div class="card-body">
    <h4 class="card-title mb-3">Edit Product</h4>
    <form method="POST" action="{{ route('admin.products.update', $product->id) }}" enctype="multipart/form-data">@csrf @method('PUT')
        <div class="row g-3">
            <div class="col-md-4"><label class="form-label">Category</label><select name="category_id" class="form-select @error('category_id') is-invalid @enderror" required><option value="">Select category</option>@foreach($categories as $category)<option value="{{ $category->id }}" @selected(old('category_id',$product->category_id)==$category->id)>{{ $category->localized_name }}</option>@endforeach</select>@error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
            <div class="col-md-4"><label class="form-label">Slug</label><input name="slug" class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug',$product->slug) }}" required>@error('slug')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
            <div class="col-md-4"><label class="form-label">Sort Order</label><input type="number" name="sort_order" min="0" class="form-control @error('sort_order') is-invalid @enderror" value="{{ old('sort_order',$product->sort_order) }}">@error('sort_order')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>

            <div class="col-md-4"><label class="form-label">Name (Default)</label><input name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name',$product->name) }}" required></div>
            <div class="col-md-4"><label class="form-label">Name (AR)</label><input name="name_ar" class="form-control" value="{{ old('name_ar',$product->name_ar) }}"></div>
            <div class="col-md-4"><label class="form-label">Name (EN)</label><input name="name_en" class="form-control" value="{{ old('name_en',$product->name_en) }}"></div>

            <div class="col-md-4"><label class="form-label">Tagline (Default)</label><input name="tagline" class="form-control" value="{{ old('tagline',$product->tagline) }}"></div>
            <div class="col-md-4"><label class="form-label">Tagline (AR)</label><input name="tagline_ar" class="form-control" value="{{ old('tagline_ar',$product->tagline_ar) }}"></div>
            <div class="col-md-4"><label class="form-label">Tagline (EN)</label><input name="tagline_en" class="form-control" value="{{ old('tagline_en',$product->tagline_en) }}"></div>

            <div class="col-md-4"><label class="form-label">Short Description (Default)</label><input name="short_description" class="form-control" value="{{ old('short_description',$product->short_description) }}"></div>
            <div class="col-md-4"><label class="form-label">Short Description (AR)</label><input name="short_description_ar" class="form-control" value="{{ old('short_description_ar',$product->short_description_ar) }}"></div>
            <div class="col-md-4"><label class="form-label">Short Description (EN)</label><input name="short_description_en" class="form-control" value="{{ old('short_description_en',$product->short_description_en) }}"></div>

            <div class="col-md-4"><label class="form-label">Price</label><input type="number" step="0.01" name="price" class="form-control" value="{{ old('price',$product->price) }}"></div>
            <div class="col-md-4"><label class="form-label">Price Note</label><input name="price_note" class="form-control" value="{{ old('price_note',$product->price_note) }}"></div>
            <div class="col-md-4"><label class="form-label">Image</label><input type="file" name="image" accept="image/*" class="form-control @error('image') is-invalid @enderror">@error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>

            <div class="col-12"><img src="{{ $product->image ? Storage::url($product->image) : asset('img/service-1.jpg') }}" alt="{{ $product->localized_name }}" class="rounded border" style="width: 60px; height: 60px; object-fit: cover;"></div>

            <div class="col-md-12"><label class="form-label">Description (Default)</label><textarea name="description" class="form-control" rows="3">{{ old('description',$product->description) }}</textarea></div>
            <div class="col-md-6"><label class="form-label">Description (AR)</label><textarea name="description_ar" class="form-control" rows="3">{{ old('description_ar',$product->description_ar) }}</textarea></div>
            <div class="col-md-6"><label class="form-label">Description (EN)</label><textarea name="description_en" class="form-control" rows="3">{{ old('description_en',$product->description_en) }}</textarea></div>

            <div class="col-md-12"><label class="form-label">Key Features (one per line)</label><textarea name="key_features" class="form-control" rows="3">{{ old('key_features', implode(PHP_EOL, $product->key_features ?? [])) }}</textarea></div>
            <div class="col-md-12"><label class="form-label">Use Cases (Default)</label><textarea name="use_cases" class="form-control" rows="2">{{ old('use_cases',$product->use_cases) }}</textarea></div>
            <div class="col-md-6"><label class="form-label">Use Cases (AR)</label><textarea name="use_cases_ar" class="form-control" rows="2">{{ old('use_cases_ar',$product->use_cases_ar) }}</textarea></div>
            <div class="col-md-6"><label class="form-label">Use Cases (EN)</label><textarea name="use_cases_en" class="form-control" rows="2">{{ old('use_cases_en',$product->use_cases_en) }}</textarea></div>
        </div>

        <div class="form-check mt-3"><input class="form-check-input" type="checkbox" name="is_featured" value="1" id="is_featured" @checked(old('is_featured',$product->is_featured))><label class="form-check-label" for="is_featured">Featured</label></div>
        <div class="form-check mb-3"><input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active" @checked(old('is_active',$product->is_active))><label class="form-check-label" for="is_active">Active</label></div>
        <button class="btn btn-primary" type="submit">Update</button> <a href="{{ route('admin.products.index') }}" class="btn btn-outline-primary">Cancel</a>
    </form>
</div></div>
@endsection
