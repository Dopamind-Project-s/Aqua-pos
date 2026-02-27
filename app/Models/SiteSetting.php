<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'type',
        'group',
        'is_public',
        'site_name',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'facebook_url',
        'instagram_url',
        'linkedin_url',
        'twitter_url',
        'youtube_url',
        'tiktok_url',
        'whatsapp_number',
        'google_map_embed',
        'hq_title',
        'hq_address',
        'info_email',
        'support_email',
        'phone_primary',
        'phone_secondary',
        'footer_company_title',
        'footer_company_description',
    ];

    protected function casts(): array
    {
        return [
            'is_public' => 'boolean',
        ];
    }
}
