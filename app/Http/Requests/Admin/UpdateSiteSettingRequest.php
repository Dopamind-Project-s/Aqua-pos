<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSiteSettingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'site_name' => ['required', 'string', 'max:255'],
            'primary_logo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,svg', 'max:2048'],
            'secondary_logo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,svg', 'max:2048'],
            'home_solution_video' => ['nullable', 'file', 'mimetypes:video/mp4,video/webm,video/ogg', 'max:204800'],

            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string'],
            'meta_keywords' => ['nullable', 'string', 'max:255'],
            'gtm_container_id' => ['nullable', 'string', 'max:50'],
            'ga4_measurement_id' => ['nullable', 'string', 'max:50'],
            'google_ads_conversion_id' => ['nullable', 'string', 'max:100'],
            'google_ads_conversion_label' => ['nullable', 'string', 'max:100'],
            'meta_pixel_id' => ['nullable', 'string', 'max:100'],
            'google_site_verification' => ['nullable', 'string', 'max:255'],
            'search_console_property' => ['nullable', 'string', 'max:255'],
            'ms_clarity_project_id' => ['nullable', 'string', 'max:100'],

            'facebook_url' => ['nullable', 'url', 'max:255'],
            'instagram_url' => ['nullable', 'url', 'max:255'],
            'linkedin_url' => ['nullable', 'url', 'max:255'],
            'twitter_url' => ['nullable', 'url', 'max:255'],
            'youtube_url' => ['nullable', 'url', 'max:255'],
            'tiktok_url' => ['nullable', 'url', 'max:255'],

            'whatsapp_number' => ['nullable', 'string', 'max:50'],
            'google_map_embed' => ['nullable', 'string'],

            'hq_title' => ['nullable', 'string', 'max:255'],
            'hq_address' => ['nullable', 'string', 'max:255'],
            'info_email' => ['nullable', 'email', 'max:255'],
            'support_email' => ['nullable', 'email', 'max:255'],
            'phone_primary' => ['nullable', 'string', 'max:50'],
            'phone_secondary' => ['nullable', 'string', 'max:50'],

            'footer_company_title' => ['nullable', 'string', 'max:255'],
            'footer_company_description' => ['nullable', 'string'],
            'about_site_paragraph' => ['nullable', 'string'],
        ];
    }
}
