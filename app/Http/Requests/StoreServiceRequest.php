<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreServiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'type' => ['required', Rule::in(['contact_request', 'support_request', 'demo_request'])],
            'full_name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'company' => ['nullable', 'string', 'max:255'],
            'country' => ['nullable', 'string', 'max:255'],
            'product_interest' => ['nullable', 'string', 'max:255'],
            'branch_count' => ['nullable', 'integer', 'min:1'],
            'preferred_contact_time' => ['nullable', 'string', 'max:255'],
            'subject' => ['nullable', 'string', 'max:255'],
            'message' => ['nullable', 'string'],
            'source_page' => ['nullable', 'string', 'max:255'],
            'selected_partner_id' => ['nullable', 'integer', 'exists:partners,id'],
            'status' => ['nullable', Rule::in(['new', 'in_progress', 'closed'])],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'status' => $this->input('status', 'new'),
            'source_page' => $this->input('source_page', url()->current()),
        ]);
    }
}
