<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

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

    public function getLocalizedNameAttribute(): string
    {
        $locale = app()->getLocale();

        if ($locale === 'ar') {
            return $this->name_ar ?: $this->name_en ?: $this->name;
        }

        return $this->name_en ?: $this->name_ar ?: $this->name;
    }

    public function getLocalizedTaglineAttribute(): ?string
    {
        $locale = app()->getLocale();

        if ($locale === 'ar') {
            return $this->tagline_ar ?: $this->tagline_en ?: $this->tagline;
        }

        return $this->tagline_en ?: $this->tagline_ar ?: $this->tagline;
    }

    public function getLocalizedShortDescriptionAttribute(): ?string
    {
        $locale = app()->getLocale();

        if ($locale === 'ar') {
            return $this->short_description_ar ?: $this->short_description_en ?: $this->short_description;
        }

        return $this->short_description_en ?: $this->short_description_ar ?: $this->short_description;
    }

    public function getLocalizedDescriptionAttribute(): ?string
    {
        $locale = app()->getLocale();

        if ($locale === 'ar') {
            return $this->description_ar ?: $this->description_en ?: $this->description;
        }

        return $this->description_en ?: $this->description_ar ?: $this->description;
    }

    public function getLocalizedUseCasesAttribute(): ?string
    {
        $locale = app()->getLocale();

        if ($locale === 'ar') {
            return $this->use_cases_ar ?: $this->use_cases_en ?: $this->use_cases;
        }

        return $this->use_cases_en ?: $this->use_cases_ar ?: $this->use_cases;
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
