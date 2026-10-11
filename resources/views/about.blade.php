@extends('layouts.app')

@section('content')
    @include('partials.page-hero', [
        'section' => 'about-hero',
        'icon' => 'fas fa-info-circle',
        'badge' => 'About Us',
        'badgeI18n' => 'about.heroBadge',
        'title' => 'About Us',
        'titleI18n' => 'about.heroTitle',
        'subtitle' => 'Discover the team and platform helping businesses run smarter POS operations.',
        'subtitleI18n' => 'about.heroSubtitle',
    ])

    @include('home.sections.about', ['aboutCmsNamespace' => 'about.about'])
@endsection
