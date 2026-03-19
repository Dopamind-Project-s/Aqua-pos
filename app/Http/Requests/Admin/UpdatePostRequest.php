<?php

namespace App\Http\Requests\Admin;

use App\Support\JsonTranslation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'title' => JsonTranslation::encode($this->input('title_ar'), $this->input('title_en'), $this->input('title_en')) ?? (string) $this->input('title_en', ''),
            'excerpt' => JsonTranslation::encode($this->input('excerpt_ar'), $this->input('excerpt_en')),
            'content' => JsonTranslation::encode($this->input('content_ar'), $this->input('content_en'), $this->input('content_en')),
        ]);
    }

    public function rules(): array
    {
        $postId = $this->route('post')?->id;

        return [
            'type' => ['required', Rule::in(['blog', 'news'])],
            'title' => ['required', 'string', 'max:255'],
            'title_ar' => ['nullable', 'string', 'max:255'],
            'title_en' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', Rule::unique('posts', 'slug')->ignore($postId)],
            'excerpt' => ['nullable', 'string'],
            'excerpt_ar' => ['nullable', 'string'],
            'excerpt_en' => ['nullable', 'string'],
            'content' => ['required', 'string'],
            'content_ar' => ['nullable', 'string'],
            'content_en' => ['required', 'string'],
            'cover_image' => ['nullable', 'image', 'max:2048'],
            'category_id' => ['nullable', 'integer', Rule::exists('categories', 'id')->whereNull('deleted_at')],
            'author_id' => ['nullable', 'integer', Rule::exists('users', 'id')],
            'published_at' => ['nullable', 'date'],
            'status' => ['required', Rule::in(['draft', 'published', 'archived'])],
        ];
    }
}
