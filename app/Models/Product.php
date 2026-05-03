<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Support\JsonTranslation;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_id',
        'name',
        'name_ar',
        'name_en',
        'tagline',
        'tagline_ar',
        'tagline_en',
        'slug',
        'image',
        'short_description',
        'short_description_ar',
        'short_description_en',
        'description',
        'description_ar',
        'description_en',
        'key_features',
        'use_cases',
        'use_cases_ar',
        'use_cases_en',
        'price',
        'price_note',
        'sort_order',
        'is_featured',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'key_features' => 'array',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    public function getImageUrlAttribute(): string
    {
        return public_storage_url($this->image, asset('img/service-1.jpg'));
    }

    public function getLocalizedNameAttribute(): string
    {
        return JsonTranslation::pick($this->getRawOriginal('name'), $this->name_ar, $this->name_en, app()->getLocale()) ?? '';
    }

    public function getLocalizedTaglineAttribute(): ?string
    {
        return JsonTranslation::pick($this->getRawOriginal('tagline'), $this->tagline_ar, $this->tagline_en, app()->getLocale());
    }

    public function getLocalizedShortDescriptionAttribute(): ?string
    {
        return JsonTranslation::pick($this->getRawOriginal('short_description'), $this->short_description_ar, $this->short_description_en, app()->getLocale());
    }

    public function getLocalizedDescriptionAttribute(): ?string
    {
        return JsonTranslation::pick($this->getRawOriginal('description'), $this->description_ar, $this->description_en, app()->getLocale());
    }

    public function getLocalizedUseCasesAttribute(): ?string
    {
        return JsonTranslation::pick($this->getRawOriginal('use_cases'), $this->use_cases_ar, $this->use_cases_en, app()->getLocale());
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class);
    }
}
