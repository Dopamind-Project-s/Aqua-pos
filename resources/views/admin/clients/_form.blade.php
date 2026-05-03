@php($isEdit = isset($client))

<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label" for="category_id">Category</label>
        <select class="form-select @error('category_id') is-invalid @enderror" id="category_id" name="category_id">
            <option value="">No category</option>
            @foreach(($categories ?? collect()) as $category)
                <option value="{{ $category->id }}" @selected(old('category_id', $client->category_id ?? null) == $category->id)>{{ $category->localized_name }}</option>
            @endforeach
        </select>
        @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-6">
        <label class="form-label" for="name_ar">Client Name (AR)</label>
        <input type="text" class="form-control @error('name_ar') is-invalid @enderror" id="name_ar" name="name_ar" value="{{ old('name_ar', $client->name_ar ?? '') }}">
        @error('name_ar')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-6">
        <label class="form-label" for="name_en">Client Name (EN - Default) *</label>
        <input type="text" class="form-control @error('name_en') is-invalid @enderror" id="name_en" name="name_en" value="{{ old('name_en', $client->name_en ?? $client->name ?? '') }}" required>
        @error('name_en')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-6">
        <label class="form-label" for="logo">Logo {{ $isEdit ? '' : '*' }}</label>
        <input type="file" class="form-control @error('logo') is-invalid @enderror" id="logo" name="logo" accept=".jpg,.jpeg,.png,.webp,.svg" {{ $isEdit ? '' : 'required' }}>
        @error('logo')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-6">
        <label class="form-label" for="description_ar">Description (AR)</label>
        <textarea class="form-control @error('description_ar') is-invalid @enderror" id="description_ar" name="description_ar" rows="3">{{ old('description_ar', $client->description_ar ?? '') }}</textarea>
        @error('description_ar')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-6">
        <label class="form-label" for="description_en">Description (EN - Default)</label>
        <textarea class="form-control @error('description_en') is-invalid @enderror" id="description_en" name="description_en" rows="3">{{ old('description_en', $client->description_en ?? $client->description ?? '') }}</textarea>
        @error('description_en')<div class="invalid-feedback">{{ $message }}</div>@enderror
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
        <input type="number" min="0" class="form-control @error('sort_order') is-invalid @enderror" id="sort_order" name="sort_order" value="{{ old('sort_order', $client->sort_order ?? 0) }}">
        @error('sort_order')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-3 d-flex align-items-center">
        <div class="form-check form-switch mt-4">
            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $client->is_active ?? true) ? 'checked' : '' }}>
            <label class="form-check-label" for="is_active">Active</label>
        </div>
    </div>

    @if($isEdit && $client->logo)
        <div class="col-12">
            <p class="mb-1 fw-semibold">Current Logo</p>
            <img src="{{ public_storage_url($client->logo) }}" alt="{{ $client->localized_name }}" class="rounded border object-fit-contain bg-white" width="120" height="90">
        </div>
    @endif
</div>
