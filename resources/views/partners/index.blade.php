@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
<style>
    .partners-map-shell {
        margin-bottom: 32px;
    }

    .partners-map {
        width: 100%;
        min-height: 460px;
        border: 1px solid var(--partners-card-border);
        border-radius: 8px;
        box-shadow: var(--partners-card-shadow);
        overflow: hidden;
        background: #eef3f8;
    }

    .partners-map-popup {
        min-width: 190px;
    }

    .partners-map-popup__title {
        font-weight: 800;
        color: #12325a;
        margin-bottom: 4px;
    }

    .partners-map-popup__location {
        color: #5d6b82;
        margin-bottom: 10px;
    }

    .partners-map-popup__link {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 12px;
        border-radius: 8px;
        background: var(--color-primary);
        color: #fff;
        text-decoration: none;
        font-weight: 700;
    }

    .partners-map-popup__link:hover {
        color: #fff;
        background: var(--color-primary-hover);
    }

    body.dark-mode .partners-map {
        border-color: var(--color-border);
        box-shadow: var(--partners-card-shadow);
    }

    @media (max-width: 576px) {
        .partners-map {
            min-height: 360px;
        }
    }
</style>
@endpush

@section('content')
@include('partials.page-hero', [
    'icon' => 'fas fa-handshake',
    'badge' => 'Strategic Ecosystem',
    'badgeI18n' => 'partners.eyebrow',
    'title' => 'Enterprise Partnerships That Scale',
    'titleI18n' => 'partners.title',
    'subtitle' => 'We collaborate with high-impact brands and technology leaders to deliver seamless, scalable, and future-ready solutions.',
    'subtitleI18n' => 'partners.subtitle',
])

<section class="partners-section">
    <div class="container">
        @if($mapPartners->isNotEmpty())
            <div class="partners-map-shell">
                <div class="partners-toolbar d-flex flex-wrap justify-content-between align-items-center gap-3 mb-3">
                    <div>
                        <h2 class="partners-toolbar__title mb-1" data-i18n="partners.mapTitle">Find Partners On The Map</h2>
                        <p class="partners-toolbar__subtitle mb-0" data-i18n="partners.mapSubtitle">Click any pin to contact us about that exact partner location.</p>
                    </div>
                </div>
                <div id="partnersMap" class="partners-map" data-partners='@json($mapPartners)'></div>
            </div>
        @else
            <div class="partners-empty-state text-center">
                <div class="partners-empty-state__icon"><i class="fas fa-handshake"></i></div>
                <h2 data-i18n="partners.emptyTitle">No partners yet</h2>
                <p data-i18n="partners.emptySubtitle">We are currently onboarding exceptional partners. Please check back soon.</p>
            </div>
        @endif
    </div>
</section>
@endsection

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const mapEl = document.getElementById('partnersMap');

        if (!mapEl || !window.L) {
            return;
        }

        const partners = JSON.parse(mapEl.dataset.partners || '[]');
        const getLocale = function () {
            return document.documentElement.getAttribute('lang') === 'ar' ? 'ar' : 'en';
        };
        const labels = {
            ar: {
                contact: 'تواصل معنا',
                fallbackLocation: 'موقع الشريك',
            },
            en: {
                contact: 'Contact Us',
                fallbackLocation: 'Partner location',
            },
        };
        const tileProviders = {
            ar: {
                url: 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
                options: {
                    maxZoom: 19,
                    attribution: '&copy; OpenStreetMap contributors',
                },
            },
            en: {
                url: 'https://server.arcgisonline.com/ArcGIS/rest/services/World_Street_Map/MapServer/tile/{z}/{y}/{x}',
                options: {
                    maxZoom: 19,
                    attribution: 'Tiles &copy; Esri',
                },
            },
        };
        const map = L.map(mapEl, {
            scrollWheelZoom: false,
        }).setView([31.9539, 35.9106], 7);
        const bounds = partners.map(function (partner) {
            return [partner.latitude, partner.longitude];
        });
        const markerLayer = L.layerGroup().addTo(map);
        let tileLayer = null;

        const setTileLayer = function () {
            const provider = tileProviders[getLocale()];

            if (tileLayer) {
                map.removeLayer(tileLayer);
            }

            tileLayer = L.tileLayer(provider.url, provider.options).addTo(map);
            tileLayer.bringToBack();
        };

        const escapeHtml = function (value) {
            return String(value || '').replace(/[&<>"']/g, function (character) {
                return {
                    '&': '&amp;',
                    '<': '&lt;',
                    '>': '&gt;',
                    '"': '&quot;',
                    "'": '&#039;',
                }[character];
            });
        };

        const renderMarkers = function () {
            const locale = getLocale();

            markerLayer.clearLayers();

            partners.forEach(function (partner) {
                const point = [partner.latitude, partner.longitude];
                const name = locale === 'ar' ? partner.nameAr : partner.nameEn;
                const location = (locale === 'ar' ? partner.locationAr : partner.locationEn) || labels[locale].fallbackLocation;

                L.marker(point).addTo(markerLayer).bindPopup(`
                    <div class="partners-map-popup">
                        <div class="partners-map-popup__title">${escapeHtml(name)}</div>
                        <div class="partners-map-popup__location">${escapeHtml(location)}</div>
                        <a class="partners-map-popup__link" href="${escapeHtml(partner.contactUrl)}">
                            <i class="fas fa-paper-plane"></i>
                            <span>${labels[locale].contact}</span>
                        </a>
                    </div>
                `);
            });
        };

        setTileLayer();
        renderMarkers();

        if (bounds.length === 1) {
            map.setView(bounds[0], 12);
        } else if (bounds.length > 1) {
            map.fitBounds(bounds, { padding: [40, 40] });
        }

        document.addEventListener('aqua:language-changed', function () {
            setTileLayer();
            renderMarkers();
        });
    });
</script>
@endpush
