@extends('layouts.admin')
@section('content')
<div class="card"><div class="card-body"><h4 class="mb-4">Create Client</h4>
<form action="{{ route('admin.clients.store') }}" method="POST" enctype="multipart/form-data">@csrf
@include('admin.clients._form')
<div class="mt-4"><button class="btn btn-primary">Create Client</button></div>
</form></div></div>
@endsection
