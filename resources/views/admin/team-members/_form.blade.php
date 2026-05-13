@php($isEdit = isset($teamMember))

<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label" for="name_ar">Name (AR)</label>
        <input type="text" class="form-control @error('name_ar') is-invalid @enderror" id="name_ar" name="name_ar" value="{{ old('name_ar', $teamMember->name_ar ?? '') }}">
        @error('name_ar')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-6">
        <label class="form-label" for="name_en">Name (EN - Default) *</label>
        <input type="text" class="form-control @error('name_en') is-invalid @enderror" id="name_en" name="name_en" value="{{ old('name_en', $teamMember->name_en ?? '') }}" required>
        @error('name_en')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-6">
        <label class="form-label" for="role_ar">Role (AR)</label>
        <input type="text" class="form-control @error('role_ar') is-invalid @enderror" id="role_ar" name="role_ar" value="{{ old('role_ar', $teamMember->role_ar ?? '') }}">
        @error('role_ar')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-6">
        <label class="form-label" for="role_en">Role (EN)</label>
        <input type="text" class="form-control @error('role_en') is-invalid @enderror" id="role_en" name="role_en" value="{{ old('role_en', $teamMember->role_en ?? '') }}">
        @error('role_en')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-6">
        <label class="form-label" for="bio_ar">Bio (AR)</label>
        <textarea class="form-control @error('bio_ar') is-invalid @enderror" id="bio_ar" name="bio_ar" rows="4">{{ old('bio_ar', $teamMember->bio_ar ?? '') }}</textarea>
        @error('bio_ar')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-6">
        <label class="form-label" for="bio_en">Bio (EN)</label>
        <textarea class="form-control @error('bio_en') is-invalid @enderror" id="bio_en" name="bio_en" rows="4">{{ old('bio_en', $teamMember->bio_en ?? '') }}</textarea>
        @error('bio_en')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-6">
        <label class="form-label" for="photo">Photo</label>
        <input type="file" class="form-control @error('photo') is-invalid @enderror" id="photo" name="photo" accept=".jpg,.jpeg,.png,.webp">
        @error('photo')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-6">
        <label class="form-label" for="email">Email</label>
        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $teamMember->email ?? '') }}">
        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-3">
        <label class="form-label" for="linkedin_url">LinkedIn</label>
        <input type="url" class="form-control @error('linkedin_url') is-invalid @enderror" id="linkedin_url" name="linkedin_url" value="{{ old('linkedin_url', $teamMember->linkedin_url ?? '') }}">
        @error('linkedin_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-3">
        <label class="form-label" for="facebook_url">Facebook</label>
        <input type="url" class="form-control @error('facebook_url') is-invalid @enderror" id="facebook_url" name="facebook_url" value="{{ old('facebook_url', $teamMember->facebook_url ?? '') }}">
        @error('facebook_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-3">
        <label class="form-label" for="instagram_url">Instagram</label>
        <input type="url" class="form-control @error('instagram_url') is-invalid @enderror" id="instagram_url" name="instagram_url" value="{{ old('instagram_url', $teamMember->instagram_url ?? '') }}">
        @error('instagram_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-3">
        <label class="form-label" for="twitter_url">Twitter / X</label>
        <input type="url" class="form-control @error('twitter_url') is-invalid @enderror" id="twitter_url" name="twitter_url" value="{{ old('twitter_url', $teamMember->twitter_url ?? '') }}">
        @error('twitter_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-3">
        <label class="form-label" for="sort_order">Display Order</label>
        <input type="number" min="0" class="form-control @error('sort_order') is-invalid @enderror" id="sort_order" name="sort_order" value="{{ old('sort_order', $teamMember->sort_order ?? 0) }}">
        @error('sort_order')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-3 d-flex align-items-center">
        <div class="form-check form-switch mt-4">
            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $teamMember->is_active ?? true) ? 'checked' : '' }}>
            <label class="form-check-label" for="is_active">Active</label>
        </div>
    </div>

    @if($isEdit && $teamMember->photo)
        <div class="col-12">
            <p class="mb-1 fw-semibold">Current Photo</p>
            <img src="{{ $teamMember->photo_url }}" alt="{{ $teamMember->localized_name }}" class="rounded border object-fit-cover bg-white" width="110" height="110">
        </div>
    @endif
</div>
