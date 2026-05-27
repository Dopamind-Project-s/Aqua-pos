@extends('layouts.app')

@section('content')
    <!-- Header Start -->
    <div class="container-fluid bg-breadcrumb">
        <div class="container text-center py-4" style="max-width: 900px;">
            <span class="inner-hero-badge mb-3 wow fadeInDown" data-wow-delay="0.05s"><i class="fas fa-info-circle"></i> About Us</span>
            <h1 class="text-white display-5 fw-bold mb-3 wow fadeInDown" data-wow-delay="0.1s">About Us</h1>
            <p class="lead mb-0 wow fadeInDown" data-wow-delay="0.2s">Discover the team and platform helping businesses run smarter POS operations.</p>
        </div>
    </div>
    <!-- Header End -->

    @include('home.sections.about', ['aboutCmsNamespace' => 'about.about'])
@endsection
