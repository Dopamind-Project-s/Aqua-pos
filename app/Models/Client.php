<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Client extends Model
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
        ];
    }

public function getLogoUrlAttribute(): string
{
    $placeholder = asset('img/defaults/placeholder.svg');

    if (! $this->logo) {
        return $placeholder;
    }

    // إذا كان URL كامل
    if (filter_var($this->logo, FILTER_VALIDATE_URL)) {
        return $this->logo;
    }

    // تنظيف المسار (إزالة storage/ إذا موجودة)
    $path = ltrim(preg_replace('#^/?storage/#', '', $this->logo), '/');

    return asset('storage/' . $path);
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
}
