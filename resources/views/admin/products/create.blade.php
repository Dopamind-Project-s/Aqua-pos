@extends('layouts.admin')

@section('content')
@include('admin.partials.flexy-shell-start')
@include('admin.partials.flash-messages')
<div class="card"><div class="card-body">
    <h4 class="card-title mb-3">Create Product</h4>
    <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">@csrf
        <div class="mb-3"><label class="form-label">Category</label><select name="category_id" class="form-select @error('category_id') is-invalid @enderror" required><option value="">Select category</option>@foreach($categories as $category)<option value="{{ $category->id }}" @selected(old('category_id')==$category->id)>{{ $category->name }}</option>@endforeach</select>@error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
        <div class="mb-3"><label class="form-label">Name</label><input name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required></div>
        <div class="mb-3"><label class="form-label">Slug</label><input name="slug" class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug') }}" required></div>
        <div class="mb-3"><label class="form-label">Image</label><input type="file" name="image" accept="image/*" class="form-control @error('image') is-invalid @enderror">@error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror<small class="text-muted">Max 2MB</small></div>
        <div class="mb-3"><label class="form-label">Short Description</label><input name="short_description" class="form-control" value="{{ old('short_description') }}"></div>
        <div class="mb-3"><label class="form-label">Description</label><textarea name="description" class="form-control" rows="4">{{ old('description') }}</textarea></div>
        <div class="row"><div class="col-md-6 mb-3"><label class="form-label">Price</label><input type="number" step="0.01" name="price" class="form-control" value="{{ old('price') }}"></div><div class="col-md-6 mb-3"><label class="form-label">Price Note</label><input name="price_note" class="form-control" value="{{ old('price_note') }}"></div></div>
        <div class="form-check"><input class="form-check-input" type="checkbox" name="is_featured" value="1" id="is_featured" @checked(old('is_featured'))><label class="form-check-label" for="is_featured">Featured</label></div>
        <div class="form-check mb-3"><input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active" @checked(old('is_active',1))><label class="form-check-label" for="is_active">Active</label></div>
        <button class="btn btn-primary" type="submit">Save</button> <a href="{{ route('admin.products.index') }}" class="btn btn-outline-primary">Cancel</a>
    </form>
</div></div>
@include('admin.partials.flexy-shell-end')
@endsection
