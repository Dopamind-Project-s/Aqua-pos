@extends('layouts.admin')

@section('content')
@include('admin.partials.flash-messages')
<div class="card">
    <div class="card-body">
        <h4 class="card-title mb-4">Create Team Member</h4>
        <form action="{{ route('admin.team-members.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @include('admin.team-members._form')
            <div class="mt-4 d-flex gap-2">
                <button class="btn btn-primary" type="submit">Create Team Member</button>
                <a href="{{ route('admin.team-members.index') }}" class="btn btn-light">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
