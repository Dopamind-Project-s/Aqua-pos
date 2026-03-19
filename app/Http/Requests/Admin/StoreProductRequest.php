<?php

namespace App\Http\Requests\Admin;

use App\Support\JsonTranslation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            // Keep legacy columns synced and store bilingual payload as JSON without schema change.
            'name' => (string) $this->input('name_en', ''),
            'tagline' => $this->input('tagline_en'),
            'short_description' => $this->input('short_description_en'),
            'description' => $this->input('description_en'),
            'use_cases' => $this->input('use_cases_en'),
            'is_active' => $this->boolean('is_active'),
            'is_featured' => $this->boolean('is_featured'),
            'key_features' => $this->filled('key_features')
                ? array_values(array_filter(array_map('trim', explode(PHP_EOL, (string) $this->input('key_features')))))
                : null,
        ]);

        $this->merge([
            'name' => JsonTranslation::encode($this->input('name_ar'), $this->input('name_en'), $this->input('name_en')) ?? (string) $this->input('name_en', ''),
            'tagline' => JsonTranslation::encode($this->input('tagline_ar'), $this->input('tagline_en')),
            'short_description' => JsonTranslation::encode($this->input('short_description_ar'), $this->input('short_description_en')),
            'description' => JsonTranslation::encode($this->input('description_ar'), $this->input('description_en')),
            'use_cases' => JsonTranslation::encode($this->input('use_cases_ar'), $this->input('use_cases_en')),
        ]);
    }

    public function rules(): array
    {
        return [
            'category_id' => ['required', 'integer', Rule::exists('categories', 'id')->whereNull('deleted_at')],
            'name' => ['required', 'string', 'max:255'],
            'name_ar' => ['nullable', 'string', 'max:255'],
            'name_en' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', Rule::unique('products', 'slug')],
            'image' => ['nullable', 'image', 'max:2048'],
            'gallery_images' => ['nullable', 'array', 'max:12'],
            'gallery_images.*' => ['image', 'max:2048'],
            'gallery_alt' => ['nullable', 'array'],
            'gallery_alt.*' => ['nullable', 'string', 'max:255'],
            'tagline' => ['nullable', 'string', 'max:255'],
            'tagline_ar' => ['nullable', 'string', 'max:255'],
            'tagline_en' => ['nullable', 'string', 'max:255'],
            'short_description' => ['nullable', 'string', 'max:255'],
            'short_description_ar' => ['nullable', 'string', 'max:255'],
            'short_description_en' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'description_ar' => ['nullable', 'string'],
            'description_en' => ['nullable', 'string'],
            'key_features' => ['nullable', 'array'],
            'key_features.*' => ['nullable', 'string', 'max:255'],
            'use_cases' => ['nullable', 'string'],
            'use_cases_ar' => ['nullable', 'string'],
            'use_cases_en' => ['nullable', 'string'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'price_note' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_featured' => ['required', 'boolean'],
            'is_active' => ['required', 'boolean'],
        ];
    }
}
