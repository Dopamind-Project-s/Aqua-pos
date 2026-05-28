@php($isEdit = isset($partner))

<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label" for="name_ar">Partner Name (AR)</label>
        <input type="text" class="form-control @error('name_ar') is-invalid @enderror" id="name_ar" name="name_ar" value="{{ old('name_ar', $partner->name_ar ?? '') }}">
        @error('name_ar')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-6">
        <label class="form-label" for="name_en">Partner Name (EN - Default) *</label>
        <input type="text" class="form-control @error('name_en') is-invalid @enderror" id="name_en" name="name_en" value="{{ old('name_en', $partner->name_en ?? $partner->name ?? '') }}" required>
        @error('name_en')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-6">
        <label class="form-label" for="logo">Logo {{ $isEdit ? '' : '*' }}</label>
        <input type="file" class="form-control @error('logo') is-invalid @enderror" id="logo" name="logo" accept=".jpg,.jpeg,.png,.webp,.svg" {{ $isEdit ? '' : 'required' }}>
        @error('logo')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-6">
        <label class="form-label" for="website_url">Website URL</label>
        <input type="url" class="form-control @error('website_url') is-invalid @enderror" id="website_url" name="website_url" value="{{ old('website_url', $partner->website_url ?? '') }}">
        @error('website_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-6">
        <label class="form-label" for="description_ar">Description (AR)</label>
        <textarea class="form-control @error('description_ar') is-invalid @enderror" id="description_ar" name="description_ar" rows="3">{{ old('description_ar', $partner->description_ar ?? '') }}</textarea>
        @error('description_ar')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-6">
        <label class="form-label" for="description_en">Description (EN - Default)</label>
        <textarea class="form-control @error('description_en') is-invalid @enderror" id="description_en" name="description_en" rows="3">{{ old('description_en', $partner->description_en ?? $partner->description ?? '') }}</textarea>
        @error('description_en')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-6">
        <label class="form-label" for="apply_url">Apply Link</label>
        <input type="url" class="form-control @error('apply_url') is-invalid @enderror" id="apply_url" name="apply_url" value="{{ old('apply_url', $partner->apply_url ?? '') }}">
        @error('apply_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-12">
        <div class="border rounded p-3 bg-light">
            <div class="d-flex flex-wrap justify-content-between gap-2 mb-3">
                <div>
                    <h6 class="mb-1">Partner Map Pin</h6>
                    <small class="text-muted">Click the map to place the public partner pin.</small>
                </div>
                <button type="button" class="btn btn-sm btn-outline-secondary" id="clearPartnerPin">Clear Pin</button>
            </div>

            <div id="adminPartnerMap" class="admin-partner-map mb-3"></div>

            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label" for="map_latitude">Latitude</label>
                    <input type="number" step="0.0000001" min="-90" max="90" class="form-control @error('map_latitude') is-invalid @enderror" id="map_latitude" name="map_latitude" value="{{ old('map_latitude', $partner->map_latitude ?? '') }}">
                    @error('map_latitude')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-3">
                    <label class="form-label" for="map_longitude">Longitude</label>
                    <input type="number" step="0.0000001" min="-180" max="180" class="form-control @error('map_longitude') is-invalid @enderror" id="map_longitude" name="map_longitude" value="{{ old('map_longitude', $partner->map_longitude ?? '') }}">
                    @error('map_longitude')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-3">
                    <label class="form-label" for="map_location_ar">Map Label (AR)</label>
                    <input type="text" class="form-control @error('map_location_ar') is-invalid @enderror" id="map_location_ar" name="map_location_ar" value="{{ old('map_location_ar', $partner->map_location_ar ?? '') }}">
                    @error('map_location_ar')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-3">
                    <label class="form-label" for="map_location_en">Map Label (EN)</label>
                    <input type="text" class="form-control @error('map_location_en') is-invalid @enderror" id="map_location_en" name="map_location_en" value="{{ old('map_location_en', $partner->map_location_en ?? '') }}">
                    @error('map_location_en')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <label class="form-label" for="facebook_url">Facebook</label>
        <input type="url" class="form-control @error('facebook_url') is-invalid @enderror" id="facebook_url" name="facebook_url" value="{{ old('facebook_url', $partner->facebook_url ?? '') }}">
        @error('facebook_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-4">
        <label class="form-label" for="instagram_url">Instagram</label>
        <input type="url" class="form-control @error('instagram_url') is-invalid @enderror" id="instagram_url" name="instagram_url" value="{{ old('instagram_url', $partner->instagram_url ?? '') }}">
        @error('instagram_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-4">
        <label class="form-label" for="linkedin_url">LinkedIn</label>
        <input type="url" class="form-control @error('linkedin_url') is-invalid @enderror" id="linkedin_url" name="linkedin_url" value="{{ old('linkedin_url', $partner->linkedin_url ?? '') }}">
        @error('linkedin_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6">
        <label class="form-label" for="twitter_url">Twitter</label>
        <input type="url" class="form-control @error('twitter_url') is-invalid @enderror" id="twitter_url" name="twitter_url" value="{{ old('twitter_url', $partner->twitter_url ?? '') }}">
        @error('twitter_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6">
        <label class="form-label" for="youtube_url">YouTube</label>
        <input type="url" class="form-control @error('youtube_url') is-invalid @enderror" id="youtube_url" name="youtube_url" value="{{ old('youtube_url', $partner->youtube_url ?? '') }}">
        @error('youtube_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-3">
        <label class="form-label" for="sort_order">Display Order</label>
        <input type="number" min="0" class="form-control @error('sort_order') is-invalid @enderror" id="sort_order" name="sort_order" value="{{ old('sort_order', $partner->sort_order ?? 0) }}">
        @error('sort_order')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-3 d-flex align-items-center">
        <div class="form-check form-switch mt-4">
            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $partner->is_active ?? true) ? 'checked' : '' }}>
            <label class="form-check-label" for="is_active">Active</label>
        </div>
    </div>

    @if($isEdit && $partner->logo)
        <div class="col-12">
            <p class="mb-1 fw-semibold">Current Logo</p>
            <img src="{{ public_storage_url($partner->logo) }}" alt="{{ $partner->localized_name }}" class="rounded border object-fit-contain bg-white" width="120" height="90">
        </div>
    @endif
</div>

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
<style>
    .admin-partner-map {
        width: 100%;
        min-height: 360px;
        border: 1px solid #d9e5f8;
        border-radius: 8px;
        overflow: hidden;
        background: #eef3f8;
    }
</style>
@endpush

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const mapEl = document.getElementById('adminPartnerMap');
        const latInput = document.getElementById('map_latitude');
        const lngInput = document.getElementById('map_longitude');
        const clearButton = document.getElementById('clearPartnerPin');

        if (!mapEl || !window.L) {
            return;
        }

        const defaultCenter = [31.9539, 35.9106];
        const initialLat = parseFloat(latInput.value);
        const initialLng = parseFloat(lngInput.value);
        const hasInitialPin = Number.isFinite(initialLat) && Number.isFinite(initialLng);
        const map = L.map(mapEl).setView(hasInitialPin ? [initialLat, initialLng] : defaultCenter, hasInitialPin ? 12 : 7);
        let marker = null;
        let tileLayer = null;
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

        const getLocale = function () {
            return document.documentElement.getAttribute('lang') === 'ar' ? 'ar' : 'en';
        };

        const setTileLayer = function () {
            const provider = tileProviders[getLocale()];

            if (tileLayer) {
                map.removeLayer(tileLayer);
            }

            tileLayer = L.tileLayer(provider.url, provider.options).addTo(map);
            tileLayer.bringToBack();
        };

        setTileLayer();

        const setPin = function (lat, lng, shouldPan = true) {
            latInput.value = Number(lat).toFixed(7);
            lngInput.value = Number(lng).toFixed(7);

            if (!marker) {
                marker = L.marker([lat, lng], { draggable: true }).addTo(map);
                marker.on('dragend', function (event) {
                    const position = event.target.getLatLng();
                    setPin(position.lat, position.lng, false);
                });
            } else {
                marker.setLatLng([lat, lng]);
            }

            if (shouldPan) {
                map.setView([lat, lng], Math.max(map.getZoom(), 12));
            }
        };

        if (hasInitialPin) {
            setPin(initialLat, initialLng, false);
        }

        map.on('click', function (event) {
            setPin(event.latlng.lat, event.latlng.lng);
        });

        [latInput, lngInput].forEach(function (input) {
            input.addEventListener('change', function () {
                const lat = parseFloat(latInput.value);
                const lng = parseFloat(lngInput.value);

                if (Number.isFinite(lat) && Number.isFinite(lng)) {
                    setPin(lat, lng);
                }
            });
        });

        clearButton?.addEventListener('click', function () {
            latInput.value = '';
            lngInput.value = '';

            if (marker) {
                map.removeLayer(marker);
                marker = null;
            }
        });

        document.addEventListener('aqua:language-changed', setTileLayer);
    });
</script>
@endpush
