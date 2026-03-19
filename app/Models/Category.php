<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Support\JsonTranslation;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'name_ar',
        'name_en',
        'description',
        'description_ar',
        'description_en',
        'image',
        'slug',
        'sort_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function getLocalizedNameAttribute(): string
    {
        return JsonTranslation::pick($this->getRawOriginal('name'), $this->name_ar, $this->name_en, app()->getLocale()) ?? '';
    }

    public function getLocalizedDescriptionAttribute(): ?string
    {
        return JsonTranslation::pick($this->getRawOriginal('description'), $this->description_ar, $this->description_en, app()->getLocale());
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }
}
