@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        @include('admin.partials.sidebar')

        <main class="col-md-9 col-lg-10 p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="mb-0">Category Details</h2>
                <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Back</a>
            </div>

            @include('admin.partials.flash-messages')

            <div class="card">
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-sm-3">Name</dt>
                        <dd class="col-sm-9">{{ $category->name }}</dd>

                        <dt class="col-sm-3">Slug</dt>
                        <dd class="col-sm-9">{{ $category->slug }}</dd>

                        <dt class="col-sm-3">Description</dt>
                        <dd class="col-sm-9">{{ $category->description ?: '-' }}</dd>

                        <dt class="col-sm-3">Status</dt>
                        <dd class="col-sm-9">
                            <span class="badge {{ $category->is_active ? 'bg-success' : 'bg-secondary' }}">
                                {{ $category->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </dd>

                        <dt class="col-sm-3">Created At</dt>
                        <dd class="col-sm-9">{{ $category->created_at?->format('Y-m-d H:i') }}</dd>

                        <dt class="col-sm-3">Updated At</dt>
                        <dd class="col-sm-9">{{ $category->updated_at?->format('Y-m-d H:i') }}</dd>
                    </dl>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection
