@extends('layouts.app')

@section('content')
<div class="container-fluid bg-breadcrumb"><div class="container text-center py-5" style="max-width: 900px;"><h3 class="text-white display-5 mb-3">Request Product Demo</h3></div></div>
<div class="container py-5">
    @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
    <div class="card p-4 shadow-sm">
        <form method="POST" action="{{ route('requests.store') }}" class="row g-3">@csrf
            <input type="hidden" name="type" value="demo_request">
            <input type="hidden" name="source_page" value="/request-product-demo">
            <div class="col-md-6"><label class="form-label">Full Name</label><input class="form-control" name="full_name" required></div>
            <div class="col-md-6"><label class="form-label">Email</label><input type="email" class="form-control" name="email"></div>
            <div class="col-md-6"><label class="form-label">Phone</label><input class="form-control" name="phone"></div>
            <div class="col-md-6"><label class="form-label">Company</label><input class="form-control" name="company"></div>
            <div class="col-md-6"><label class="form-label">Country</label><input class="form-control" name="country"></div>
            <div class="col-md-6"><label class="form-label">Branches</label><input type="number" min="1" class="form-control" name="branch_count"></div>
            <div class="col-md-6"><label class="form-label">Product Interest</label><input class="form-control" name="product_interest"></div>
            <div class="col-md-6"><label class="form-label">Preferred Contact Time</label><input class="form-control" name="preferred_contact_time" placeholder="e.g. 10:00 AM"></div>
            <div class="col-12"><label class="form-label">Notes</label><textarea class="form-control" name="message" rows="5"></textarea></div>
            <div class="col-12"><button class="btn btn-primary">Submit Demo Request</button></div>
        </form>
    </div>
</div>
@endsection
