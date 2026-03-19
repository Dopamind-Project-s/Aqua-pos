@extends('layouts.admin')

@section('content')
@include('admin.partials.flash-messages')
<div class="card"><div class="card-body">
    <div class="d-flex justify-content-between align-items-center mb-3"><h4 class="card-title mb-0">Posts</h4><a href="{{ route('admin.posts.create') }}" class="btn btn-primary">Create Post</a></div>
    <div class="table-responsive"><table class="table text-nowrap mb-0 align-middle">
        <thead class="text-dark fs-4"><tr><th>Cover</th><th>Title</th><th>Type</th><th>Status</th><th>Category</th><th>Author</th><th class="text-end">Actions</th></tr></thead>
        <tbody>
        @forelse($posts as $post)
            <tr>
                <td><img src="{{ $post->cover_image ? Storage::url($post->cover_image) : asset('img/service-1.jpg') }}" alt="{{ $post->localized_title }}" class="rounded border" style="width:60px;height:60px;object-fit:cover;"></td>
                <td>{{ $post->localized_title }}</td>
                <td><span class="badge bg-info text-dark">{{ ucfirst($post->type) }}</span></td>
                <td>
                    @php($statusClass = ['draft' => 'bg-secondary', 'published' => 'bg-success', 'archived' => 'bg-dark'][$post->status] ?? 'bg-secondary')
                    <span class="badge {{ $statusClass }}">{{ ucfirst($post->status) }}</span>
                </td>
                <td>{{ $post->category?->localized_name ?? '-' }}</td>
                <td>{{ $post->author?->name ?? '-' }}</td>
                <td class="text-end"><a class="btn btn-sm btn-info" href="{{ route('admin.posts.show',$post->id) }}">View</a> <a class="btn btn-sm btn-warning" href="{{ route('admin.posts.edit',$post->id) }}">Edit</a> <form action="{{ route('admin.posts.destroy',$post->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this post?');">@csrf @method('DELETE')<button class="btn btn-sm btn-danger" type="submit">Delete</button></form></td>
            </tr>
        @empty
            <tr><td colspan="7" class="text-center">No posts found.</td></tr>
        @endforelse
        </tbody>
    </table></div>
    {{ $posts->links() }}
</div></div>
@endsection
