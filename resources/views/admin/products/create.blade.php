@extends('layouts.admin')

@section('content')
@include('admin.partials.flash-messages')
<div class="card"><div class="card-body">
    <h4 class="card-title mb-1">Create Product</h4>
    <p class="text-muted mb-3">English fields are treated as default automatically.</p>
    <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">@csrf
        <div class="row g-3">
            <div class="col-md-4"><label class="form-label">Category</label><select name="category_id" class="form-select @error('category_id') is-invalid @enderror" required><option value="">Select category</option>@foreach($categories as $category)<option value="{{ $category->id }}" @selected(old('category_id')==$category->id)>{{ $category->localized_name }}</option>@endforeach</select>@error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
            <div class="col-md-4"><label class="form-label">Slug</label><input name="slug" class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug') }}" required>@error('slug')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
            <div class="col-md-4"><label class="form-label">Sort Order</label><input type="number" name="sort_order" min="0" class="form-control @error('sort_order') is-invalid @enderror" value="{{ old('sort_order',0) }}">@error('sort_order')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>

            <div class="col-md-6"><label class="form-label">Name (AR)</label><input name="name_ar" class="form-control @error('name_ar') is-invalid @enderror" value="{{ old('name_ar') }}">@error('name_ar')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
            <div class="col-md-6"><label class="form-label">Name (EN - Default)</label><input name="name_en" class="form-control @error('name_en') is-invalid @enderror" value="{{ old('name_en') }}" required>@error('name_en')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>

            <div class="col-md-6"><label class="form-label">Tagline (AR)</label><input name="tagline_ar" class="form-control" value="{{ old('tagline_ar') }}"></div>
            <div class="col-md-6"><label class="form-label">Tagline (EN - Default)</label><input name="tagline_en" class="form-control" value="{{ old('tagline_en') }}"></div>

            <div class="col-md-6"><label class="form-label">Short Description (AR)</label><input name="short_description_ar" class="form-control" value="{{ old('short_description_ar') }}"></div>
            <div class="col-md-6"><label class="form-label">Short Description (EN - Default)</label><input name="short_description_en" class="form-control" value="{{ old('short_description_en') }}"></div>

            <div class="col-md-4"><label class="form-label">Price</label><input type="number" step="0.01" name="price" class="form-control" value="{{ old('price') }}"></div>
            <div class="col-md-4"><label class="form-label">Price Note</label><input name="price_note" class="form-control" value="{{ old('price_note') }}"></div>
            <div class="col-md-4"><label class="form-label">Image</label><input type="file" name="image" accept="image/*" class="form-control @error('image') is-invalid @enderror">@error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>

            <div class="col-md-6"><label class="form-label">Description (AR)</label><textarea name="description_ar" class="form-control" rows="3">{{ old('description_ar') }}</textarea></div>
            <div class="col-md-6"><label class="form-label">Description (EN - Default)</label><textarea name="description_en" class="form-control" rows="3">{{ old('description_en') }}</textarea></div>

            <div class="col-md-12"><label class="form-label">Key Features (one per line)</label><textarea name="key_features" class="form-control" rows="3">{{ old('key_features') }}</textarea></div>
            <div class="col-md-6"><label class="form-label">Use Cases (AR)</label><textarea name="use_cases_ar" class="form-control" rows="2">{{ old('use_cases_ar') }}</textarea></div>
            <div class="col-md-6"><label class="form-label">Use Cases (EN - Default)</label><textarea name="use_cases_en" class="form-control" rows="2">{{ old('use_cases_en') }}</textarea></div>
        </div>

        <div class="form-check mt-3"><input class="form-check-input" type="checkbox" name="is_featured" value="1" id="is_featured" @checked(old('is_featured'))><label class="form-check-label" for="is_featured">Featured</label></div>
        <div class="form-check mb-3"><input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active" @checked(old('is_active',1))><label class="form-check-label" for="is_active">Active</label></div>

        <button class="btn btn-primary" type="submit">Save</button>
        <a href="{{ route('admin.products.index') }}" class="btn btn-outline-primary">Cancel</a>
    </form>
</div></div>
@endsection
