@extends('layouts.admin')
@section('content')
<div class="card"><div class="card-body"><h4 class="mb-4">Edit Client</h4>
<form action="{{ route('admin.clients.update', $client) }}" method="POST" enctype="multipart/form-data">@csrf @method('PUT')
@include('admin.clients._form')
<div class="mt-4"><button class="btn btn-primary">Update Client</button></div>
</form></div></div>
@endsection
