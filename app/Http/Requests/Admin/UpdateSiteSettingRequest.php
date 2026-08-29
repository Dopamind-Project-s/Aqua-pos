<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSiteSettingRequest extends FormRequest
{
    protected function prepareForValidation(): void
    {
        $this->merge([
            'tracking_method' => strtolower(trim((string) $this->input('tracking_method', 'none'))),
            'ga4_measurement_id' => $this->normalizeGoogleId('ga4_measurement_id'),
            'gtm_container_id' => $this->normalizeGoogleId('gtm_container_id'),
        ]);
    }

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
            'tracking_method' => ['required', Rule::in(['none', 'ga4', 'gtm'])],
            'gtm_container_id' => ['nullable', 'required_if:tracking_method,gtm', 'string', 'max:50', 'regex:/^GTM-[A-Z0-9]+$/'],
            'ga4_measurement_id' => ['nullable', 'required_if:tracking_method,ga4', 'string', 'max:50', 'regex:/^G-[A-Z0-9]+$/'],
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

    public function messages(): array
    {
        return [
            'tracking_method.required' => 'Choose a tracking method. / اختر طريقة التتبع.',
            'tracking_method.in' => 'The selected tracking method is invalid. / طريقة التتبع المحددة غير صالحة.',
            'ga4_measurement_id.required_if' => 'GA4 Measurement ID is required for direct tracking. / معرّف GA4 مطلوب للتتبع المباشر.',
            'ga4_measurement_id.regex' => 'Use a valid GA4 Measurement ID such as G-XXXXXXXXXX. / أدخل معرّف GA4 صحيحًا بالشكل G-XXXXXXXXXX.',
            'gtm_container_id.required_if' => 'GTM Container ID is required for Tag Manager. / معرّف GTM مطلوب لاستخدام Tag Manager.',
            'gtm_container_id.regex' => 'Use a valid GTM Container ID such as GTM-XXXXXXX. / أدخل معرّف GTM صحيحًا بالشكل GTM-XXXXXXX.',
        ];
    }

    private function normalizeGoogleId(string $key): ?string
    {
        $value = trim((string) $this->input($key, ''));

        return $value === '' ? null : strtoupper($value);
    }
}
