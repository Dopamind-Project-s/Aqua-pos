<?php

namespace App\Http\Requests\Admin;

use App\Support\JsonTranslation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCategoryRequest extends FormRequest
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
            'description' => $this->input('description_en'),
            'is_active' => $this->boolean('is_active'),
        ]);

        $nameJson = JsonTranslation::encode(
            $this->input('name_ar'),
            $this->input('name_en'),
            $this->input('name_en')
        );

        $descriptionJson = JsonTranslation::encode(
            $this->input('description_ar'),
            $this->input('description_en')
        );

        $this->merge([
            'name' => $nameJson ?? (string) $this->input('name_en', ''),
            'description' => $descriptionJson,
        ]);
    }

    public function rules(): array
    {
        $categoryId = $this->route('category');

        return [
            'name' => ['required', 'string', 'max:255'],
            'name_ar' => ['nullable', 'string', 'max:255'],
            'name_en' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', Rule::unique('categories', 'slug')->ignore($categoryId)],
            'description' => ['nullable', 'string'],
            'description_ar' => ['nullable', 'string'],
            'description_en' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,svg,webp', 'max:4096'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['required', 'boolean'],
        ];
    }
}
