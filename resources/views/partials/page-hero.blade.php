@php
    $hasOffset = $offset ?? true;
    $heroClass = trim('support-hero page-hero ' . ($hasOffset ? 'page-hero--offset ' : '') . ($class ?? ''));
    $containerClass = trim('container py-4 text-center ' . ($containerClass ?? ''));
@endphp

<section class="{{ $heroClass }}" @isset($section) data-cms-section="{{ $section }}" @endisset>
    <div class="{{ $containerClass }}">
        <span class="support-badge page-hero__badge mb-3">
            <i class="{{ $icon ?? 'fas fa-life-ring' }}"></i>
            <span @isset($badgeI18n) data-i18n="{{ $badgeI18n }}" @endisset @isset($badgeCmsKey) data-cms-key="{{ $badgeCmsKey }}" @endisset>{{ $badge ?? 'Support Center' }}</span>
        </span>
        @if(filled($title ?? null))
            <h1 class="display-5 fw-bold mb-3" @isset($titleI18n) data-i18n="{{ $titleI18n }}" @endisset @isset($titleCmsKey) data-cms-key="{{ $titleCmsKey }}" @endisset>{{ $title }}</h1>
        @endif
        <p class="lead mb-0" @isset($subtitleI18n) data-i18n="{{ $subtitleI18n }}" @endisset @isset($subtitleCmsKey) data-cms-key="{{ $subtitleCmsKey }}" @endisset>{{ $subtitle ?? '' }}</p>
    </div>
</section>
