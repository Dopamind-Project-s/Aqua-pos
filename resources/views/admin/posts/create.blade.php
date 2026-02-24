@extends('layouts.admin')

@section('content')
@include('admin.partials.flash-messages')
<div class="card"><div class="card-body">
    <h4 class="card-title mb-3">Create Post</h4>
    <form method="POST" action="{{ route('admin.posts.store') }}" enctype="multipart/form-data">@csrf
        <div class="row">
            <div class="col-md-6 mb-3"><label class="form-label">Type</label><select name="type" class="form-select @error('type') is-invalid @enderror" required><option value="blog" @selected(old('type')==='blog')>Blog</option><option value="news" @selected(old('type')==='news')>News</option></select>@error('type')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
            <div class="col-md-6 mb-3"><label class="form-label">Status</label><select name="status" class="form-select @error('status') is-invalid @enderror" required><option value="draft" @selected(old('status','draft')==='draft')>Draft</option><option value="published" @selected(old('status')==='published')>Published</option><option value="archived" @selected(old('status')==='archived')>Archived</option></select>@error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
        </div>
        <div class="mb-3"><label class="form-label">Title</label><input name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" required>@error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
        <div class="mb-3"><label class="form-label">Slug</label><input name="slug" class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug') }}" required>@error('slug')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
        <div class="mb-3"><label class="form-label">Excerpt</label><textarea name="excerpt" class="form-control @error('excerpt') is-invalid @enderror" rows="2">{{ old('excerpt') }}</textarea>@error('excerpt')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
        <div class="mb-3"><label class="form-label">Content</label><textarea name="content" class="form-control @error('content') is-invalid @enderror" rows="6" required>{{ old('content') }}</textarea>@error('content')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
        <div class="mb-3"><label class="form-label">Cover Image</label><input type="file" name="cover_image" accept="image/*" class="form-control @error('cover_image') is-invalid @enderror">@error('cover_image')<div class="invalid-feedback">{{ $message }}</div>@enderror<small class="text-muted">Max 2MB</small></div>
        <div class="row">
            <div class="col-md-6 mb-3"><label class="form-label">Category</label><select name="category_id" class="form-select @error('category_id') is-invalid @enderror"><option value="">No category</option>@foreach($categories as $category)<option value="{{ $category->id }}" @selected(old('category_id')==$category->id)>{{ $category->name }}</option>@endforeach</select>@error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
            <div class="col-md-6 mb-3"><label class="form-label">Author</label><select name="author_id" class="form-select @error('author_id') is-invalid @enderror"><option value="">No author</option>@foreach($authors as $author)<option value="{{ $author->id }}" @selected(old('author_id')==$author->id)>{{ $author->name }}</option>@endforeach</select>@error('author_id')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
        </div>
        <div class="mb-3"><label class="form-label">Published At</label><input type="datetime-local" name="published_at" class="form-control @error('published_at') is-invalid @enderror" value="{{ old('published_at') }}">@error('published_at')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
        <button class="btn btn-primary" type="submit">Save</button> <a href="{{ route('admin.posts.index') }}" class="btn btn-outline-primary">Cancel</a>
    </form>
</div></div>
@endsection
