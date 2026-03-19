@extends('layouts.admin')

@section('content')
@include('admin.partials.flash-messages')
<div class="card">
    <div class="card-body">
        <h4 class="card-title mb-3">Site Settings</h4>
        @php
            $trackingChecklist = [
                'GTM Container ID configured' => !empty($setting->gtm_container_id),
                'GA4 Measurement ID configured' => !empty($setting->ga4_measurement_id),
                'Google Ads Conversion ID configured' => !empty($setting->google_ads_conversion_id),
                'Google Ads Conversion Label configured' => !empty($setting->google_ads_conversion_label),
                'Meta Pixel ID configured' => !empty($setting->meta_pixel_id),
                'Google site verification token added' => !empty($setting->google_site_verification),
                'Search Console property recorded' => !empty($setting->search_console_property),
                'Microsoft Clarity project ID configured' => !empty($setting->ms_clarity_project_id),
            ];
            $trackingDoneCount = collect($trackingChecklist)->filter()->count();
            $trackingTotalCount = count($trackingChecklist);
            $trackingRemainingCount = $trackingTotalCount - $trackingDoneCount;
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
                    <label class="form-label">Primary Logo</label>
                    <input type="file" name="primary_logo" class="form-control @error('primary_logo') is-invalid @enderror" accept=".jpg,.jpeg,.png,.webp,.svg">
                    @error('primary_logo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    @if($setting->primary_logo)
                        <img src="{{ Storage::url($setting->primary_logo) }}" alt="Primary Logo" class="img-thumbnail mt-2" style="max-height: 80px;">
                    @endif
                </div>

                <div class="col-md-4">
                    <label class="form-label">Secondary Logo</label>
                    <input type="file" name="secondary_logo" class="form-control @error('secondary_logo') is-invalid @enderror" accept=".jpg,.jpeg,.png,.webp,.svg">
                    @error('secondary_logo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    @if($setting->secondary_logo)
                        <img src="{{ Storage::url($setting->secondary_logo) }}" alt="Secondary Logo" class="img-thumbnail mt-2" style="max-height: 80px;">
                    @endif
                </div>

                <div class="col-md-4"><label class="form-label">Meta Title</label><input type="text" name="meta_title" value="{{ old('meta_title', $setting->meta_title) }}" class="form-control @error('meta_title') is-invalid @enderror">@error('meta_title')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                <div class="col-md-4"><label class="form-label">Meta Keywords</label><input type="text" name="meta_keywords" value="{{ old('meta_keywords', $setting->meta_keywords) }}" class="form-control @error('meta_keywords') is-invalid @enderror">@error('meta_keywords')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                <div class="col-12"><label class="form-label">Meta Description</label><textarea name="meta_description" rows="3" class="form-control @error('meta_description') is-invalid @enderror">{{ old('meta_description', $setting->meta_description) }}</textarea>@error('meta_description')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>

                <div class="col-12 mt-4" id="tracking-settings">
                    <div class="border rounded-3 p-3 bg-light">
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-2">
                            <h5 class="mb-0">Tracking & Marketing Integrations</h5>
                            <span class="badge bg-primary">Done: {{ $trackingDoneCount }} / {{ $trackingTotalCount }}</span>
                        </div>
                        <p class="text-muted mb-3">Remaining tasks: <strong>{{ $trackingRemainingCount }}</strong></p>
                        <div class="row g-2">
                            @foreach($trackingChecklist as $taskLabel => $done)
                                <div class="col-md-6">
                                    <div class="d-flex justify-content-between align-items-center border rounded-2 px-2 py-2 bg-white">
                                        <span>{{ $taskLabel }}</span>
                                        <span class="badge {{ $done ? 'bg-success' : 'bg-warning text-dark' }}">{{ $done ? 'Done' : 'Pending' }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="col-md-3"><label class="form-label">GTM Container ID</label><input type="text" name="gtm_container_id" value="{{ old('gtm_container_id', $setting->gtm_container_id) }}" class="form-control @error('gtm_container_id') is-invalid @enderror" placeholder="GTM-XXXXXXX">@error('gtm_container_id')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                <div class="col-md-3"><label class="form-label">GA4 Measurement ID</label><input type="text" name="ga4_measurement_id" value="{{ old('ga4_measurement_id', $setting->ga4_measurement_id) }}" class="form-control @error('ga4_measurement_id') is-invalid @enderror" placeholder="G-XXXXXXXXXX">@error('ga4_measurement_id')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                <div class="col-md-3"><label class="form-label">Google Ads Conversion ID</label><input type="text" name="google_ads_conversion_id" value="{{ old('google_ads_conversion_id', $setting->google_ads_conversion_id) }}" class="form-control @error('google_ads_conversion_id') is-invalid @enderror">@error('google_ads_conversion_id')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                <div class="col-md-3"><label class="form-label">Google Ads Conversion Label</label><input type="text" name="google_ads_conversion_label" value="{{ old('google_ads_conversion_label', $setting->google_ads_conversion_label) }}" class="form-control @error('google_ads_conversion_label') is-invalid @enderror">@error('google_ads_conversion_label')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>

                <div class="col-md-3"><label class="form-label">Meta Pixel ID</label><input type="text" name="meta_pixel_id" value="{{ old('meta_pixel_id', $setting->meta_pixel_id) }}" class="form-control @error('meta_pixel_id') is-invalid @enderror">@error('meta_pixel_id')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                <div class="col-md-3"><label class="form-label">Google Site Verification</label><input type="text" name="google_site_verification" value="{{ old('google_site_verification', $setting->google_site_verification) }}" class="form-control @error('google_site_verification') is-invalid @enderror">@error('google_site_verification')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                <div class="col-md-3"><label class="form-label">Search Console Property</label><input type="text" name="search_console_property" value="{{ old('search_console_property', $setting->search_console_property) }}" class="form-control @error('search_console_property') is-invalid @enderror" placeholder="sc-domain:example.com">@error('search_console_property')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                <div class="col-md-3"><label class="form-label">Microsoft Clarity Project ID</label><input type="text" name="ms_clarity_project_id" value="{{ old('ms_clarity_project_id', $setting->ms_clarity_project_id) }}" class="form-control @error('ms_clarity_project_id') is-invalid @enderror">@error('ms_clarity_project_id')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>

                <div class="col-md-6"><label class="form-label">Footer Company Title</label><input type="text" name="footer_company_title" value="{{ old('footer_company_title', $setting->footer_company_title) }}" class="form-control"></div>
                <div class="col-md-6"><label class="form-label">Head Quarter Title</label><input type="text" name="hq_title" value="{{ old('hq_title', $setting->hq_title) }}" class="form-control"></div>
                <div class="col-12"><label class="form-label">Footer Company Description</label><textarea name="footer_company_description" rows="3" class="form-control">{{ old('footer_company_description', $setting->footer_company_description) }}</textarea></div>
                <div class="col-12"><label class="form-label">About Site Paragraph</label><textarea name="about_site_paragraph" rows="4" class="form-control">{{ old('about_site_paragraph', $setting->about_site_paragraph) }}</textarea></div>

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
