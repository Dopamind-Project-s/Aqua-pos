@php($isEdit = isset($partner))

<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label" for="name">Partner Name *</label>
        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $partner->name ?? '') }}" required>
        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-6">
        <label class="form-label" for="logo">Logo {{ $isEdit ? '' : '*' }}</label>
        <input type="file" class="form-control @error('logo') is-invalid @enderror" id="logo" name="logo" accept=".jpg,.jpeg,.png,.webp,.svg" {{ $isEdit ? '' : 'required' }}>
        @error('logo')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-12">
        <label class="form-label" for="description">Description</label>
        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4">{{ old('description', $partner->description ?? '') }}</textarea>
        @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-6">
        <label class="form-label" for="website_url">Website URL</label>
        <input type="url" class="form-control @error('website_url') is-invalid @enderror" id="website_url" name="website_url" value="{{ old('website_url', $partner->website_url ?? '') }}">
        @error('website_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
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
            <img src="{{ Storage::url($partner->logo) }}" alt="{{ $partner->name }}" class="rounded border object-fit-contain bg-white" width="120" height="90">
        </div>
    @endif
</div>
