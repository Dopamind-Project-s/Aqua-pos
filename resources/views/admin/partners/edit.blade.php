@extends('layouts.admin')

@section('content')
@include('admin.partials.flash-messages')
<div class="card">
    <div class="card-body">
        <h4 class="card-title mb-4">Edit Partner</h4>
        <form action="{{ route('admin.partners.update', $partner) }}" method="POST">
            @csrf
            @method('PUT')
            @include('admin.partners._form')
            <div class="mt-4 d-flex gap-2">
                <button class="btn btn-primary" type="submit">Update Partner</button>
                <a href="{{ route('admin.partners.index') }}" class="btn btn-light">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
