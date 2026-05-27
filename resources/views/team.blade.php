@extends('layouts.app')

@section('content')
@php
    $locale = app()->getLocale();
    $fallbackTeamMembers = collect([
        [
            'key' => 'member_1',
            'image' => asset('img/team-1.jpg'),
            'name' => 'Sarah Haddad',
            'role' => 'Implementation Lead',
            'bio' => 'Guides restaurant and retail teams from setup to go-live with clear workflows and practical training.',
        ],
        [
            'key' => 'member_2',
            'image' => asset('img/team-2.jpg'),
            'name' => 'Omar Nasser',
            'role' => 'Product Specialist',
            'bio' => 'Helps clients map POS, inventory, and reporting needs into a simple operating model.',
        ],
        [
            'key' => 'member_3',
            'image' => asset('img/team-3.jpg'),
            'name' => 'Lina Farah',
            'role' => 'Customer Success',
            'bio' => 'Supports daily adoption, answers operational questions, and keeps branches moving smoothly.',
        ],
        [
            'key' => 'member_4',
            'image' => asset('img/team-4.jpg'),
            'name' => 'Khaled Mansour',
            'role' => 'Technical Support',
            'bio' => 'Handles device, printer, and platform support with fast troubleshooting and follow-up.',
        ],
    ]);

    $displayTeamMembers = ($teamMembers ?? collect())->isNotEmpty() ? $teamMembers : $fallbackTeamMembers;
@endphp

<!-- Header Start -->
<div class="container-fluid bg-breadcrumb" data-cms-section="team-hero">
    <div class="container text-center py-4" style="max-width: 900px;">
        <span class="inner-hero-badge mb-3 wow fadeInDown" data-wow-delay="0.05s"><i class="fas fa-users"></i> <span data-i18n="nav.team">Our Team</span></span>
        <h1 class="text-white display-5 fw-bold mb-3 wow fadeInDown" data-wow-delay="0.1s" data-cms-key="title">
            {{ dynamic_content("team.team-hero.title.{$locale}", 'Our Team') }}
        </h1>
        <p class="lead mb-0 wow fadeInDown" data-wow-delay="0.2s">
            {{ dynamic_content("team.team-hero.subtitle.{$locale}", 'Meet the people supporting your onboarding, product setup, and daily operations.') }}
        </p>
    </div>
</div>
<!-- Header End -->

<!-- Team Start -->
<section class="container-fluid team team-page py-5" data-cms-section="team-list">
    <div class="container py-5">
        <div class="section-title mb-5 wow fadeInUp" data-wow-delay="0.1s">
            <div class="sub-style">
                <h4 class="sub-title px-3 mb-0" data-cms-key="intro.eyebrow">
                    {{ dynamic_content("team.team-list.intro.eyebrow.{$locale}", 'AQUA POS CREW') }}
                </h4>
            </div>
            <h2 class="display-5 mb-3" data-cms-key="intro.title">
                {{ dynamic_content("team.team-list.intro.title.{$locale}", 'Meet the People Behind Your Operations') }}
            </h2>
            <p class="mb-0" data-cms-key="intro.description">
                {{ dynamic_content("team.team-list.intro.description.{$locale}", 'A practical team for onboarding, product guidance, customer success, and technical support across every branch.') }}
            </p>
        </div>

        <div class="row g-4 justify-content-center">
            @foreach($displayTeamMembers as $index => $member)
                @php
                    $isModel = $member instanceof \App\Models\TeamMember;
                    $key = $isModel ? 'member_' . $member->id : $member['key'];
                    $name = $isModel ? $member->localized_name : dynamic_content("team.team-list.members.{$key}.name.{$locale}", $member['name']);
                    $role = $isModel ? $member->localized_role : dynamic_content("team.team-list.members.{$key}.role.{$locale}", $member['role']);
                    $bio = $isModel ? $member->localized_bio : dynamic_content("team.team-list.members.{$key}.bio.{$locale}", $member['bio']);
                    $image = $isModel ? $member->photo_url : dynamic_content("team.team-list.members.{$key}.image.src", $member['image']);
                @endphp
                <div class="col-md-6 col-lg-3 wow fadeInUp" data-wow-delay="{{ number_format(($index * 0.15) + 0.1, 2) }}s">
                    <article class="team-item h-100">
                        <div class="team-img rounded-top">
                            <img
                                src="{{ $image }}"
                                class="img-fluid rounded-top w-100"
                                alt="{{ $name }}"
                                @unless($isModel) data-cms-key="members.{{ $key }}.image" data-cms-type="image" @endunless
                            >
                            <div class="team-icon">
                                @if($isModel && $member->linkedin_url)
                                    <a class="btn btn-primary btn-sm-square text-white rounded-circle mb-2" href="{{ $member->linkedin_url }}" target="_blank" rel="noopener" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                                @endif
                                @if($isModel && $member->facebook_url)
                                    <a class="btn btn-primary btn-sm-square text-white rounded-circle mb-2" href="{{ $member->facebook_url }}" target="_blank" rel="noopener" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                                @endif
                                @if($isModel && $member->instagram_url)
                                    <a class="btn btn-primary btn-sm-square text-white rounded-circle mb-2" href="{{ $member->instagram_url }}" target="_blank" rel="noopener" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                                @endif
                                @if($isModel && $member->twitter_url)
                                    <a class="btn btn-primary btn-sm-square text-white rounded-circle mb-2" href="{{ $member->twitter_url }}" target="_blank" rel="noopener" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                                @endif
                                @if($isModel && $member->email)
                                    <a class="btn btn-primary btn-sm-square text-white rounded-circle mb-2" href="mailto:{{ $member->email }}" aria-label="Email"><i class="fas fa-envelope"></i></a>
                                @endif
                            </div>
                        </div>
                        <div class="team-content text-center rounded-bottom bg-light p-4">
                            <h5 class="mb-1" @unless($isModel) data-cms-key="members.{{ $key }}.name" @endunless>
                                {{ $name }}
                            </h5>
                            <p class="mb-3 fw-semibold" @unless($isModel) data-cms-key="members.{{ $key }}.role" @endunless>
                                {{ $role }}
                            </p>
                            <p class="team-member-bio mb-0" @unless($isModel) data-cms-key="members.{{ $key }}.bio" @endunless>
                                {{ $bio }}
                            </p>
                        </div>
                    </article>
                </div>
            @endforeach
        </div>
    </div>
</section>
<!-- Team End -->
@endsection
