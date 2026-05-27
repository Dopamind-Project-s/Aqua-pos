@extends('layouts.app')

@section('content')
    @include('partials.page-hero', [
        'icon' => 'fas fa-info-circle',
        'badge' => 'About Us',
        'title' => 'About Us',
        'subtitle' => 'Discover the team and platform helping businesses run smarter POS operations.',
    ])

    @include('home.sections.about', ['aboutCmsNamespace' => 'about.about'])
@endsection
