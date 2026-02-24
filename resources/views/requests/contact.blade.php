@extends('layouts.app')

@section('content')
<div class="container-fluid bg-breadcrumb">
    <div class="container text-center py-5" style="max-width: 900px;">
        <h3 class="text-white display-5 mb-3">Contact Request</h3>
    </div>
</div>
<div class="container py-5">
    @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
    <div class="card p-4 shadow-sm">
        <form method="POST" action="{{ route('requests.store') }}" class="row g-3">@csrf
            <input type="hidden" name="type" value="contact_request">
            <input type="hidden" name="source_page" value="/contact">
            <div class="col-md-6"><label class="form-label">Full Name</label><input class="form-control" name="full_name" required></div>
            <div class="col-md-6"><label class="form-label">Email</label><input type="email" class="form-control" name="email"></div>
            <div class="col-md-6"><label class="form-label">Phone</label><input class="form-control" name="phone"></div>
            <div class="col-md-6"><label class="form-label">Company</label><input class="form-control" name="company"></div>
            <div class="col-12"><label class="form-label">Subject</label><input class="form-control" name="subject"></div>
            <div class="col-12"><label class="form-label">Message</label><textarea class="form-control" name="message" rows="5"></textarea></div>
            <div class="col-12"><button class="btn btn-primary">Submit Contact Request</button></div>
        </form>
    </div>
</div>
@endsection
