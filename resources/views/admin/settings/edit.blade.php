@extends('layouts.admin')

@section('content')
@include('admin.partials.flash-messages')
<div class="card">
    <div class="card-body">
        <h4 class="card-title mb-3">Site Settings</h4>
        <form method="POST" action="{{ route('admin.settings.update') }}">@csrf @method('PUT')
            <div class="row g-3">
                <div class="col-md-4"><label class="form-label">Site Name</label><input type="text" name="site_name" value="{{ old('site_name', $setting->site_name) }}" class="form-control @error('site_name') is-invalid @enderror">@error('site_name')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                <div class="col-md-4"><label class="form-label">Meta Title</label><input type="text" name="meta_title" value="{{ old('meta_title', $setting->meta_title) }}" class="form-control @error('meta_title') is-invalid @enderror">@error('meta_title')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                <div class="col-md-4"><label class="form-label">Meta Keywords</label><input type="text" name="meta_keywords" value="{{ old('meta_keywords', $setting->meta_keywords) }}" class="form-control @error('meta_keywords') is-invalid @enderror">@error('meta_keywords')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                <div class="col-12"><label class="form-label">Meta Description</label><textarea name="meta_description" rows="3" class="form-control @error('meta_description') is-invalid @enderror">{{ old('meta_description', $setting->meta_description) }}</textarea>@error('meta_description')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>

                <div class="col-md-6"><label class="form-label">Footer Company Title</label><input type="text" name="footer_company_title" value="{{ old('footer_company_title', $setting->footer_company_title) }}" class="form-control"></div>
                <div class="col-md-6"><label class="form-label">Head Quarter Title</label><input type="text" name="hq_title" value="{{ old('hq_title', $setting->hq_title) }}" class="form-control"></div>
                <div class="col-12"><label class="form-label">Footer Company Description</label><textarea name="footer_company_description" rows="3" class="form-control">{{ old('footer_company_description', $setting->footer_company_description) }}</textarea></div>

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
