@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4"><div class="row">@include('admin.partials.sidebar')
<main class="col-md-9 col-lg-10 p-4">
    <h2 class="mb-3">Create Product</h2>
    @include('admin.partials.flash-messages')
    <div class="card"><div class="card-body">
        <form method="POST" action="{{ route('admin.products.store') }}">@csrf
            <div class="mb-3"><label class="form-label">Category</label>
                <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                    <option value="">Select category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" @selected(old('category_id')==$category->id)>{{ $category->name }}</option>
                    @endforeach
                </select>@error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3"><label class="form-label">Name</label><input name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>@error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
            <div class="mb-3"><label class="form-label">Slug</label><input name="slug" class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug') }}" required>@error('slug')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
            <div class="mb-3"><label class="form-label">Short Description</label><input name="short_description" class="form-control" value="{{ old('short_description') }}"></div>
            <div class="mb-3"><label class="form-label">Description</label><textarea name="description" class="form-control" rows="4">{{ old('description') }}</textarea></div>
            <div class="row"><div class="col-md-6 mb-3"><label class="form-label">Price</label><input type="number" step="0.01" name="price" class="form-control" value="{{ old('price') }}"></div><div class="col-md-6 mb-3"><label class="form-label">Price Note</label><input name="price_note" class="form-control" value="{{ old('price_note') }}"></div></div>
            <div class="form-check"><input class="form-check-input" type="checkbox" name="is_featured" value="1" id="is_featured" @checked(old('is_featured'))><label class="form-check-label" for="is_featured">Featured</label></div>
            <div class="form-check mb-3"><input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active" @checked(old('is_active',1))><label class="form-check-label" for="is_active">Active</label></div>
            <button class="btn btn-success" type="submit">Save</button>
            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div></div>
</main></div></div>
@endsection
