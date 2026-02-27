@extends('layouts.admin')

@section('content')
@include('admin.partials.flash-messages')
<div class="card"><div class="card-body">
    <h4 class="card-title mb-1">Edit Category</h4>
    <p class="text-muted mb-3">English fields are treated as default automatically.</p>
    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">@csrf @method('PUT')
        <div class="row g-3">
            <div class="col-md-6"><label class="form-label">Name (AR)</label><input type="text" name="name_ar" class="form-control @error('name_ar') is-invalid @enderror" value="{{ old('name_ar',$category->name_ar) }}">@error('name_ar')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
            <div class="col-md-6"><label class="form-label">Name (EN - Default)</label><input type="text" name="name_en" class="form-control @error('name_en') is-invalid @enderror" value="{{ old('name_en',$category->name_en) }}" required>@error('name_en')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
            <div class="col-md-6"><label class="form-label">Slug</label><input type="text" name="slug" class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug',$category->slug) }}" required>@error('slug')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
            <div class="col-md-6"><label class="form-label">Sort Order</label><input type="number" min="0" name="sort_order" class="form-control @error('sort_order') is-invalid @enderror" value="{{ old('sort_order',$category->sort_order) }}">@error('sort_order')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
            <div class="col-md-6"><label class="form-label">Description (AR)</label><textarea name="description_ar" class="form-control @error('description_ar') is-invalid @enderror" rows="3">{{ old('description_ar',$category->description_ar) }}</textarea>@error('description_ar')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
            <div class="col-md-6"><label class="form-label">Description (EN - Default)</label><textarea name="description_en" class="form-control @error('description_en') is-invalid @enderror" rows="3">{{ old('description_en',$category->description_en) }}</textarea>@error('description_en')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
        </div>
        <div class="form-check my-3"><input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active" {{ old('is_active',$category->is_active)?'checked':'' }}><label class="form-check-label" for="is_active">Active</label></div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-primary">Cancel</a>
    </form>
</div></div>
@endsection
