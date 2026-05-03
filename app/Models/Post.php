<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Support\JsonTranslation;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'title',
        'slug',
        'excerpt',
        'content',
        'cover_image',
        'category_id',
        'author_id',
        'published_at',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
        ];
    }

    public function getLocalizedTitleAttribute(): string
    {
        return JsonTranslation::extractLocale($this->getRawOriginal('title'), app()->getLocale()) ?? '';
    }

    public function getLocalizedExcerptAttribute(): ?string
    {
        return JsonTranslation::extractLocale($this->getRawOriginal('excerpt'), app()->getLocale());
    }

    public function getLocalizedContentAttribute(): ?string
    {
        return JsonTranslation::extractLocale($this->getRawOriginal('content'), app()->getLocale());
    }


    public function getCoverImageUrlAttribute(): string
    {
        return public_storage_url($this->cover_image, asset('img/blog-1.jpg'));
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}
