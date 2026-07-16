@php
    $fieldId = $id ?? 'country';
    $translationPrefix = $i18nPrefix ?? 'demo';
@endphp

<div class="{{ $columnClass ?? 'col-md-6' }} {{ $groupClass ?? '' }}">
    <label class="form-label" for="{{ $fieldId }}Display">
        <i class="fas fa-globe"></i>
        <span data-i18n="{{ $translationPrefix }}.country">Country</span>
    </label>
    <select
        name="country"
        class="{{ $chipClass ?? 'country-chip' }}"
        id="{{ $fieldId }}Display"
        data-country-select
    >
        <option value="{{ old('country') }}" selected>{{ old('country', 'Detecting your country...') }}</option>
    </select>
</div>
