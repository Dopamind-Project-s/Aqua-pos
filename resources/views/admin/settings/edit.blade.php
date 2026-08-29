@extends('layouts.admin')

@section('content')
@include('admin.partials.flash-messages')
<div class="card">
    <div class="card-body">
        <h4 class="card-title mb-3">Site Settings</h4>
        @php
            $legacyTrackingMethod = $setting->gtm_container_id ? 'gtm' : 'none';
            $selectedTrackingMethod = old('tracking_method', $setting->tracking_method ?? $legacyTrackingMethod);
            $displayGa4Id = old('ga4_measurement_id', $setting->ga4_measurement_id);
            $displayGtmId = old('gtm_container_id', $setting->gtm_container_id);
            $ga4IsValid = is_string($displayGa4Id) && preg_match('/^G-[A-Z0-9]+$/', strtoupper(trim($displayGa4Id)));
            $gtmIsValid = is_string($displayGtmId) && preg_match('/^GTM-[A-Z0-9]+$/', strtoupper(trim($displayGtmId)));
            $activeTrackingIsValid = match ($selectedTrackingMethod) {
                'ga4' => (bool) $ga4IsValid,
                'gtm' => (bool) $gtmIsValid,
                default => true,
            };
            $trackingStatus = !$activeTrackingIsValid
                ? ['Invalid value / قيمة غير صالحة', 'bg-danger']
                : match ($selectedTrackingMethod) {
                    'ga4' => ['Active: GA4 Direct / مفعّل مباشرة', 'bg-success'],
                    'gtm' => ['Active: GTM / مفعّل عبر GTM', 'bg-success'],
                    default => ['Disabled / غير مفعّل', 'bg-secondary'],
                };
        @endphp
        <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Site Name</label>
                    <input type="text" name="site_name" value="{{ old('site_name', $setting->site_name) }}" class="form-control @error('site_name') is-invalid @enderror">
                    @error('site_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label">Light Mode Logo</label>
                    <input type="file" name="primary_logo" class="form-control @error('primary_logo') is-invalid @enderror" accept=".jpg,.jpeg,.png,.webp,.svg">
                    @error('primary_logo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    @if($setting->primary_logo)
                        <img src="{{ public_storage_url($setting->primary_logo) }}" alt="Light Mode Logo" class="img-thumbnail mt-2" style="max-height: 80px;">
                    @endif
                </div>

                <div class="col-md-4">
                    <label class="form-label">Dark Mode Logo</label>
                    <input type="file" name="secondary_logo" class="form-control @error('secondary_logo') is-invalid @enderror" accept=".jpg,.jpeg,.png,.webp,.svg">
                    @error('secondary_logo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    @if($setting->secondary_logo)
                        <img src="{{ public_storage_url($setting->secondary_logo) }}" alt="Dark Mode Logo" class="img-thumbnail mt-2" style="max-height: 80px;">
                    @endif
                </div>

                <div class="col-md-4"><label class="form-label">Meta Title</label><input type="text" name="meta_title" value="{{ old('meta_title', $setting->meta_title) }}" class="form-control @error('meta_title') is-invalid @enderror">@error('meta_title')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                <div class="col-md-4"><label class="form-label">Meta Keywords</label><input type="text" name="meta_keywords" value="{{ old('meta_keywords', $setting->meta_keywords) }}" class="form-control @error('meta_keywords') is-invalid @enderror">@error('meta_keywords')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                <div class="col-12"><label class="form-label">Meta Description</label><textarea name="meta_description" rows="3" class="form-control @error('meta_description') is-invalid @enderror">{{ old('meta_description', $setting->meta_description) }}</textarea>@error('meta_description')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>

                <div class="col-12 mt-4" id="tracking-settings">
                    <div class="border rounded-3 p-3 bg-light">
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-2">
                            <div>
                                <h5 class="mb-1">Google Analytics & Tag Manager</h5>
                                <p class="text-muted mb-0">Choose exactly one tracking method. / اختر طريقة تتبع واحدة فقط.</p>
                            </div>
                            <span class="badge {{ $trackingStatus[1] }}" id="tracking-status">{{ $trackingStatus[0] }}</span>
                        </div>

                        <div class="row g-3 mt-1">
                            <div class="col-lg-4">
                                <label class="border rounded-3 bg-white p-3 h-100 d-block">
                                    <span class="d-flex gap-2 align-items-start">
                                        <input class="form-check-input tracking-method" type="radio" name="tracking_method" value="none" @checked($selectedTrackingMethod === 'none')>
                                        <span><strong>No tracking / لا يوجد تتبع</strong><br><small class="text-muted">Do not load GA4 or GTM. Saved IDs are retained.</small></span>
                                    </span>
                                </label>
                            </div>
                            <div class="col-lg-4">
                                <label class="border border-primary rounded-3 bg-white p-3 h-100 d-block">
                                    <span class="d-flex gap-2 align-items-start">
                                        <input class="form-check-input tracking-method" type="radio" name="tracking_method" value="ga4" @checked($selectedTrackingMethod === 'ga4')>
                                        <span><strong>GA4 Direct / مباشر</strong> <span class="badge bg-primary">Recommended</span><br><small class="text-muted">The easiest option; no Tag Manager setup required.</small></span>
                                    </span>
                                </label>
                            </div>
                            <div class="col-lg-4">
                                <label class="border rounded-3 bg-white p-3 h-100 d-block">
                                    <span class="d-flex gap-2 align-items-start">
                                        <input class="form-check-input tracking-method" type="radio" name="tracking_method" value="gtm" @checked($selectedTrackingMethod === 'gtm')>
                                        <span><strong>Google Tag Manager</strong> <span class="badge bg-dark">Advanced</span><br><small class="text-muted">Tags must be configured and published in GTM.</small></span>
                                    </span>
                                </label>
                            </div>

                            @error('tracking_method')<div class="col-12 text-danger small">{{ $message }}</div>@enderror

                            <div class="col-md-6" data-tracking-panel="ga4">
                                <label class="form-label">GA4 Measurement ID</label>
                                <input type="text" name="ga4_measurement_id" value="{{ $displayGa4Id }}" class="form-control text-uppercase @error('ga4_measurement_id') is-invalid @enderror" placeholder="G-XXXXXXXXXX" autocomplete="off">
                                @error('ga4_measurement_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                <div class="form-text">Enter an ID like <code>G-XXXXXXXXXX</code>. Find it at Google Analytics → Admin → Data Streams → Web.</div>
                                <a href="https://analytics.google.com/" target="_blank" rel="noopener noreferrer" class="small">Open Google Analytics <span aria-hidden="true">↗</span></a>
                            </div>

                            <div class="col-md-6" data-tracking-panel="gtm">
                                <label class="form-label">GTM Container ID</label>
                                <input type="text" name="gtm_container_id" value="{{ $displayGtmId }}" class="form-control text-uppercase @error('gtm_container_id') is-invalid @enderror" placeholder="GTM-XXXXXXX" autocomplete="off">
                                @error('gtm_container_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                <div class="form-text">Enter an ID like <code>GTM-XXXXXXX</code>. Configure and publish tags in Google Tag Manager.</div>
                                <a href="https://tagmanager.google.com/" target="_blank" rel="noopener noreferrer" class="small">Open Google Tag Manager <span aria-hidden="true">↗</span></a>
                            </div>

                            <div class="col-12">
                                <button type="button" class="btn btn-outline-primary btn-sm" id="tracking-local-check-button">Check site setup / فحص إعداد الموقع</button>
                                <div class="alert alert-info mt-2 mb-0 d-none" id="tracking-local-check" role="status">
                                    <strong>Local setup check:</strong>
                                    <span data-check-result></span>
                                    <div class="small mt-1">This checks saved format and template activation only; it does not prove that Google received data.</div>
                                    <div class="small">Final check: open GA4 → Realtime or DebugView, then visit the site in a private window.</div>
                                </div>
                            </div>

                            <div class="col-12">
                                <details class="border rounded-3 bg-white p-3">
                                    <summary class="fw-semibold">Advanced settings / إعدادات متقدمة</summary>
                                    <div class="row g-3 mt-1">
                                        <div class="col-md-3"><label class="form-label">Google Ads Conversion ID</label><input type="text" name="google_ads_conversion_id" value="{{ old('google_ads_conversion_id', $setting->google_ads_conversion_id) }}" class="form-control @error('google_ads_conversion_id') is-invalid @enderror">@error('google_ads_conversion_id')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                                        <div class="col-md-3"><label class="form-label">Google Ads Conversion Label</label><input type="text" name="google_ads_conversion_label" value="{{ old('google_ads_conversion_label', $setting->google_ads_conversion_label) }}" class="form-control @error('google_ads_conversion_label') is-invalid @enderror">@error('google_ads_conversion_label')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                                        <div class="col-md-3"><label class="form-label">Meta Pixel ID</label><input type="text" name="meta_pixel_id" value="{{ old('meta_pixel_id', $setting->meta_pixel_id) }}" class="form-control @error('meta_pixel_id') is-invalid @enderror">@error('meta_pixel_id')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                                        <div class="col-md-3"><label class="form-label">Google Site Verification</label><input type="text" name="google_site_verification" value="{{ old('google_site_verification', $setting->google_site_verification) }}" class="form-control @error('google_site_verification') is-invalid @enderror">@error('google_site_verification')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                                        <div class="col-md-6"><label class="form-label">Search Console Property</label><input type="text" name="search_console_property" value="{{ old('search_console_property', $setting->search_console_property) }}" class="form-control @error('search_console_property') is-invalid @enderror" placeholder="sc-domain:example.com">@error('search_console_property')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                                        <div class="col-md-6"><label class="form-label">Microsoft Clarity Project ID</label><input type="text" name="ms_clarity_project_id" value="{{ old('ms_clarity_project_id', $setting->ms_clarity_project_id) }}" class="form-control @error('ms_clarity_project_id') is-invalid @enderror">@error('ms_clarity_project_id')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                                    </div>
                                </details>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6"><label class="form-label">Footer Company Title</label><input type="text" name="footer_company_title" value="{{ old('footer_company_title', $setting->footer_company_title) }}" class="form-control"></div>
                <div class="col-md-6"><label class="form-label">Head Quarter Title</label><input type="text" name="hq_title" value="{{ old('hq_title', $setting->hq_title) }}" class="form-control"></div>
                <div class="col-12"><label class="form-label">Footer Company Description</label><textarea name="footer_company_description" rows="3" class="form-control">{{ old('footer_company_description', $setting->footer_company_description) }}</textarea></div>
                <div class="col-12"><label class="form-label">About Site Paragraph</label><textarea name="about_site_paragraph" rows="4" class="form-control">{{ old('about_site_paragraph', $setting->about_site_paragraph) }}</textarea></div>
                <div class="col-12">
                    <label class="form-label">Home Solution Video</label>
                    <input type="file" name="home_solution_video" class="form-control @error('home_solution_video') is-invalid @enderror" accept="video/mp4,video/webm,video/ogg">
                    @error('home_solution_video')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    @if($setting->home_solution_video)
                        <video class="mt-2 rounded border bg-dark" style="width: 100%; max-width: 420px;" controls muted>
                            <source src="{{ public_storage_url($setting->home_solution_video) }}">
                        </video>
                    @endif
                </div>

                <div class="col-md-6"><label class="form-label">Head Quarter Address</label><input type="text" name="hq_address" value="{{ old('hq_address', $setting->hq_address) }}" class="form-control"></div>
                <div class="col-md-3"><label class="form-label">Info Email</label><input type="email" name="info_email" value="{{ old('info_email', $setting->info_email) }}" class="form-control"></div>
                <div class="col-md-3"><label class="form-label">Support Email</label><input type="email" name="support_email" value="{{ old('support_email', $setting->support_email) }}" class="form-control"></div>
                <div class="col-md-3"><label class="form-label">Primary Phone</label><input type="text" name="phone_primary" value="{{ old('phone_primary', $setting->phone_primary) }}" class="form-control"></div>
                <div class="col-md-3"><label class="form-label">Secondary Phone</label><input type="text" name="phone_secondary" value="{{ old('phone_secondary', $setting->phone_secondary) }}" class="form-control"></div>
                <div class="col-md-3"><label class="form-label">WhatsApp</label><input type="text" name="whatsapp_number" value="{{ old('whatsapp_number', $setting->whatsapp_number) }}" class="form-control"></div>
                <div class="col-md-3"><label class="form-label">Google Map Embed</label><input type="text" name="google_map_embed" value="{{ old('google_map_embed', $setting->google_map_embed) }}" class="form-control"></div>

                <div class="col-md-4"><label class="form-label">Facebook URL</label><input type="url" name="facebook_url" value="{{ old('facebook_url', $setting->facebook_url) }}" class="form-control"></div>
                <div class="col-md-4"><label class="form-label">Instagram URL</label><input type="url" name="instagram_url" value="{{ old('instagram_url', $setting->instagram_url) }}" class="form-control"></div>
                <div class="col-md-4"><label class="form-label">LinkedIn URL</label><input type="url" name="linkedin_url" value="{{ old('linkedin_url', $setting->linkedin_url) }}" class="form-control"></div>
                <div class="col-md-6"><label class="form-label">Twitter URL</label><input type="url" name="twitter_url" value="{{ old('twitter_url', $setting->twitter_url) }}" class="form-control"></div>
                <div class="col-md-3"><label class="form-label">YouTube URL</label><input type="url" name="youtube_url" value="{{ old('youtube_url', $setting->youtube_url) }}" class="form-control"></div>
                <div class="col-md-3"><label class="form-label">TikTok URL</label><input type="url" name="tiktok_url" value="{{ old('tiktok_url', $setting->tiktok_url) }}" class="form-control"></div>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Save Settings</button>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    (function () {
        const methodInputs = document.querySelectorAll('.tracking-method');
        const ga4Input = document.querySelector('[name="ga4_measurement_id"]');
        const gtmInput = document.querySelector('[name="gtm_container_id"]');
        const checkButton = document.getElementById('tracking-local-check-button');
        const checkPanel = document.getElementById('tracking-local-check');
        const checkResult = checkPanel?.querySelector('[data-check-result]');

        const selectedMethod = function () {
            return document.querySelector('.tracking-method:checked')?.value || 'none';
        };

        const normalizeId = function (input) {
            if (input) input.value = input.value.trim().toUpperCase();
        };

        const updatePanels = function () {
            const method = selectedMethod();
            document.querySelectorAll('[data-tracking-panel]').forEach(function (panel) {
                const active = panel.dataset.trackingPanel === method;
                panel.classList.toggle('opacity-50', !active);
                panel.querySelector('input').setAttribute('aria-disabled', active ? 'false' : 'true');
            });
        };

        methodInputs.forEach(function (input) {
            input.addEventListener('change', updatePanels);
        });
        [ga4Input, gtmInput].forEach(function (input) {
            input?.addEventListener('blur', function () { normalizeId(input); });
        });

        checkButton?.addEventListener('click', function () {
            normalizeId(ga4Input);
            normalizeId(gtmInput);

            const method = selectedMethod();
            const valid = method === 'none'
                || (method === 'ga4' && /^G-[A-Z0-9]+$/.test(ga4Input?.value || ''))
                || (method === 'gtm' && /^GTM-[A-Z0-9]+$/.test(gtmInput?.value || ''));

            checkPanel.classList.remove('d-none', 'alert-info', 'alert-danger', 'alert-success');
            checkPanel.classList.add(valid ? 'alert-success' : 'alert-danger');
            checkResult.textContent = valid
                ? (method === 'none' ? 'Tracking is disabled; the public template will load neither GA4 nor GTM.' : 'The selected ID format is valid. Save settings to activate it in the public template.')
                : 'The selected method is missing a valid ID. Correct it before saving.';
        });

        updatePanels();
    })();
</script>
@endpush
