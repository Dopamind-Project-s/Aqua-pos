<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'page_key',
        'section_key',
        'content_json',
        'style_json',
        'is_visible',
        'sort_order',
    ];

    protected $casts = [
        'content_json' => 'array',
        'style_json' => 'array',
        'is_visible' => 'boolean',
    ];
}
