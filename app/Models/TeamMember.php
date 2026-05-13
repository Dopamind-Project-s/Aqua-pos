<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_ar',
        'name_en',
        'role_ar',
        'role_en',
        'bio_ar',
        'bio_en',
        'photo',
        'email',
        'linkedin_url',
        'facebook_url',
        'instagram_url',
        'twitter_url',
        'sort_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function getLocalizedNameAttribute(): string
    {
        return app()->getLocale() === 'ar'
            ? ($this->name_ar ?: $this->name_en)
            : ($this->name_en ?: $this->name_ar);
    }

    public function getLocalizedRoleAttribute(): ?string
    {
        return app()->getLocale() === 'ar'
            ? ($this->role_ar ?: $this->role_en)
            : ($this->role_en ?: $this->role_ar);
    }

    public function getLocalizedBioAttribute(): ?string
    {
        return app()->getLocale() === 'ar'
            ? ($this->bio_ar ?: $this->bio_en)
            : ($this->bio_en ?: $this->bio_ar);
    }

    public function getPhotoUrlAttribute(): string
    {
        return public_storage_url($this->photo, asset('img/team-1.jpg'));
    }
}
