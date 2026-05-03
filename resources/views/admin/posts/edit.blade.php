@extends('layouts.admin')

@section('content')
@include('admin.partials.flash-messages')
@php
    $titleTranslations = \App\Support\JsonTranslation::decode($post->getRawOriginal('title')) ?? ['ar' => null, 'en' => $post->title];
    $excerptTranslations = \App\Support\JsonTranslation::decode($post->getRawOriginal('excerpt')) ?? ['ar' => null, 'en' => $post->excerpt];
    $contentTranslations = \App\Support\JsonTranslation::decode($post->getRawOriginal('content')) ?? ['ar' => null, 'en' => $post->content];
@endphp
<div class="card"><div class="card-body">
    <h4 class="card-title mb-1">Edit Post</h4>
    <p class="text-muted mb-3">Arabic + English fields are stored as JSON in the same columns.</p>
    <form method="POST" action="{{ route('admin.posts.update', $post->id) }}" enctype="multipart/form-data">@csrf @method('PUT')
        <div class="row">
            <div class="col-md-6 mb-3"><label class="form-label">Type</label><select name="type" class="form-select @error('type') is-invalid @enderror" required><option value="blog" @selected(old('type', $post->type)==='blog')>Blog</option><option value="news" @selected(old('type', $post->type)==='news')>News</option></select>@error('type')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
            <div class="col-md-6 mb-3"><label class="form-label">Status</label><select name="status" class="form-select @error('status') is-invalid @enderror" required><option value="draft" @selected(old('status', $post->status)==='draft')>Draft</option><option value="published" @selected(old('status', $post->status)==='published')>Published</option><option value="archived" @selected(old('status', $post->status)==='archived')>Archived</option></select>@error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3"><label class="form-label">Title (AR)</label><input name="title_ar" class="form-control @error('title_ar') is-invalid @enderror" value="{{ old('title_ar', $titleTranslations['ar']) }}">@error('title_ar')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
            <div class="col-md-6 mb-3"><label class="form-label">Title (EN - Default)</label><input name="title_en" class="form-control @error('title_en') is-invalid @enderror" value="{{ old('title_en', $titleTranslations['en']) }}" required>@error('title_en')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
        </div>
        <div class="mb-3"><label class="form-label">Slug</label><input name="slug" class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug', $post->slug) }}" required>@error('slug')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
        <div class="row">
            <div class="col-md-6 mb-3"><label class="form-label">Excerpt (AR)</label><textarea name="excerpt_ar" class="form-control @error('excerpt_ar') is-invalid @enderror" rows="2">{{ old('excerpt_ar', $excerptTranslations['ar']) }}</textarea>@error('excerpt_ar')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
            <div class="col-md-6 mb-3"><label class="form-label">Excerpt (EN - Default)</label><textarea name="excerpt_en" class="form-control @error('excerpt_en') is-invalid @enderror" rows="2">{{ old('excerpt_en', $excerptTranslations['en']) }}</textarea>@error('excerpt_en')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3"><label class="form-label">Content (AR)</label><textarea name="content_ar" class="form-control @error('content_ar') is-invalid @enderror" rows="6">{{ old('content_ar', $contentTranslations['ar']) }}</textarea>@error('content_ar')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
            <div class="col-md-6 mb-3"><label class="form-label">Content (EN - Default)</label><textarea name="content_en" class="form-control @error('content_en') is-invalid @enderror" rows="6" required>{{ old('content_en', $contentTranslations['en']) }}</textarea>@error('content_en')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
        </div>
        <div class="mb-3"><label class="form-label">Cover Image</label><input type="file" name="cover_image" accept="image/*" class="form-control @error('cover_image') is-invalid @enderror">@error('cover_image')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
        <div class="mb-3"><img src="{{ $post->cover_image ? public_storage_url($post->cover_image) : asset('img/service-1.jpg') }}" alt="{{ $post->localized_title }}" class="rounded border" style="width: 80px; height: 80px; object-fit: cover;"></div>
        <div class="row">
            <div class="col-md-6 mb-3"><label class="form-label">Category</label><select name="category_id" class="form-select @error('category_id') is-invalid @enderror"><option value="">No category</option>@foreach($categories as $category)<option value="{{ $category->id }}" @selected(old('category_id', $post->category_id)==$category->id)>{{ $category->localized_name }}</option>@endforeach</select>@error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
            <div class="col-md-6 mb-3"><label class="form-label">Author</label><select name="author_id" class="form-select @error('author_id') is-invalid @enderror"><option value="">No author</option>@foreach($authors as $author)<option value="{{ $author->id }}" @selected(old('author_id', $post->author_id)==$author->id)>{{ $author->name }}</option>@endforeach</select>@error('author_id')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
        </div>
        <div class="mb-3"><label class="form-label">Published At</label><input type="datetime-local" name="published_at" class="form-control @error('published_at') is-invalid @enderror" value="{{ old('published_at', optional($post->published_at)->format('Y-m-d\TH:i')) }}">@error('published_at')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
        <button class="btn btn-primary" type="submit">Update</button> <a href="{{ route('admin.posts.index') }}" class="btn btn-outline-primary">Cancel</a>
    </form>
</div></div>
@endsection
