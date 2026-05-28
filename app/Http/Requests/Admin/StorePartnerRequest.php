<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StorePartnerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name_ar' => ['nullable', 'string', 'max:255'],
            'name_en' => ['required', 'string', 'max:255'],
            'map_latitude' => ['nullable', 'numeric', 'between:-90,90', 'required_with:map_longitude'],
            'map_longitude' => ['nullable', 'numeric', 'between:-180,180', 'required_with:map_latitude'],
            'map_location_ar' => ['nullable', 'string', 'max:255'],
            'map_location_en' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ];
    }
}
