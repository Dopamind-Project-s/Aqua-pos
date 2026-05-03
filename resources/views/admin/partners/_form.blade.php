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
