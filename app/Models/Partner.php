<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'name_ar',
        'name_en',
        'slug',
        'logo',
        'description',
        'description_ar',
        'description_en',
        'website_url',
        'apply_url',
        'map_latitude',
        'map_longitude',
        'map_location_ar',
        'map_location_en',
        'facebook_url',
        'instagram_url',
        'linkedin_url',
        'twitter_url',
        'youtube_url',
        'sort_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'map_latitude' => 'decimal:7',
            'map_longitude' => 'decimal:7',
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

    public function getLocalizedDescriptionAttribute(): ?string
    {
        $locale = app()->getLocale();

        if ($locale === 'ar') {
            return $this->description_ar ?: $this->description_en ?: $this->description;
        }

        return $this->description_en ?: $this->description_ar ?: $this->description;
    }

    public function getLocalizedMapLocationAttribute(): ?string
    {
        $locale = app()->getLocale();

        if ($locale === 'ar') {
            return $this->map_location_ar ?: $this->map_location_en;
        }

        return $this->map_location_en ?: $this->map_location_ar;
    }

    public function hasMapPin(): bool
    {
        return $this->map_latitude !== null && $this->map_longitude !== null;
    }
}
