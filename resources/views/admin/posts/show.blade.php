@extends('layouts.admin')

@section('content')
@include('admin.partials.flash-messages')
<div class="card"><div class="card-body">
    <div class="d-flex justify-content-between align-items-center mb-3"><h4 class="card-title mb-0">Post Details</h4><a href="{{ route('admin.posts.index') }}" class="btn btn-outline-primary">Back</a></div>
    <div class="mb-3">
        <img src="{{ $post->cover_image ? Storage::url($post->cover_image) : asset('img/service-1.jpg') }}" alt="{{ $post->localized_title }}" class="rounded border" style="width: 180px; height: 180px; object-fit: cover;">
    </div>
    <div class="table-responsive"><table class="table text-nowrap mb-0 align-middle"><tbody>
        <tr><th>Title</th><td>{{ $post->localized_title }}</td></tr>
        <tr><th>Slug</th><td>{{ $post->slug }}</td></tr>
        <tr><th>Type</th><td>{{ ucfirst($post->type) }}</td></tr>
        <tr><th>Status</th><td>{{ ucfirst($post->status) }}</td></tr>
        <tr><th>Category</th><td>{{ $post->category?->localized_name ?? '-' }}</td></tr>
        <tr><th>Author</th><td>{{ $post->author?->name ?? '-' }}</td></tr>
        <tr><th>Published At</th><td>{{ $post->published_at?->format('Y-m-d H:i') ?? '-' }}</td></tr>
    </tbody></table></div>
    <div class="mt-3">
        <h6>Excerpt</h6>
        <p class="mb-3">{{ $post->localized_excerpt ?: '-' }}</p>
        <h6>Content</h6>
        <p class="mb-0" style="white-space: pre-line;">{{ $post->localized_content }}</p>
    </div>
</div></div>
@endsection
