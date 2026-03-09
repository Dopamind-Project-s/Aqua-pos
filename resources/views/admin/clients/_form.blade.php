@php($isEdit = isset($client))

<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label" for="name">Client Name *</label>
        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $client->name ?? '') }}" required>
        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6">
        <label class="form-label" for="logo">Logo {{ $isEdit ? '' : '*' }}</label>
        <input type="file" class="form-control @error('logo') is-invalid @enderror" id="logo" name="logo" accept=".jpg,.jpeg,.png,.webp,.svg" {{ $isEdit ? '' : 'required' }}>
        @error('logo')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    @foreach(['website_url' => 'Website URL', 'facebook_url' => 'Facebook', 'instagram_url' => 'Instagram', 'linkedin_url' => 'LinkedIn', 'twitter_url' => 'Twitter', 'youtube_url' => 'YouTube'] as $field => $label)
    <div class="col-md-6">
        <label class="form-label" for="{{ $field }}">{{ $label }}</label>
        <input type="url" class="form-control @error($field) is-invalid @enderror" id="{{ $field }}" name="{{ $field }}" value="{{ old($field, $client->{$field} ?? '') }}">
        @error($field)<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    @endforeach
    <div class="col-md-3">
        <label class="form-label" for="sort_order">Display Order</label>
        <input type="number" min="0" class="form-control" id="sort_order" name="sort_order" value="{{ old('sort_order', $client->sort_order ?? 0) }}">
    </div>
    <div class="col-md-3 d-flex align-items-center">
        <div class="form-check form-switch mt-4">
            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $client->is_active ?? true) ? 'checked' : '' }}>
            <label class="form-check-label" for="is_active">Active</label>
        </div>
    </div>
</div>
