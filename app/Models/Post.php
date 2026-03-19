<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

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


    public function getCoverImageUrlAttribute(): string
    {
        $fallback = asset('img/blog-1.jpg');

        if (! $this->cover_image) {
            return $fallback;
        }

        if (str_starts_with($this->cover_image, 'http://') || str_starts_with($this->cover_image, 'https://')) {
            return $this->cover_image;
        }

        $normalizedPath = ltrim(preg_replace('#^/?storage/#', '', $this->cover_image), '/');

        if ($normalizedPath && Storage::disk('public')->exists($normalizedPath)) {
            return route('media.public', ['path' => $normalizedPath]);
        }

        return $fallback;
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
