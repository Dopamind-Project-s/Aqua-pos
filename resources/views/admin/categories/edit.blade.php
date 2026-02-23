@extends('layouts.admin')

@section('content')
@include('admin.partials.flash-messages')
<div class="card"><div class="card-body">
    <h4 class="card-title mb-3">Edit Category</h4>
    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">@csrf @method('PUT')
        <div class="mb-3"><label class="form-label">Name</label><input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name',$category->name) }}" required>@error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
        <div class="mb-3"><label class="form-label">Slug</label><input type="text" name="slug" class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug',$category->slug) }}" required>@error('slug')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
        <div class="mb-3"><label class="form-label">Description</label><textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="4">{{ old('description',$category->description) }}</textarea>@error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
        <div class="form-check mb-3"><input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active" {{ old('is_active',$category->is_active)?'checked':'' }}><label class="form-check-label" for="is_active">Active</label></div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-primary">Cancel</a>
    </form>
</div></div>
@endsection
