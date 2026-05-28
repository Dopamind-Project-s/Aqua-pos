<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class ServiceRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'full_name',
        'email',
        'phone',
        'company',
        'country',
        'product_interest',
        'branch_count',
        'preferred_contact_time',
        'subject',
        'message',
        'source_page',
        'selected_partner_id',
        'selected_partner_snapshot',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'selected_partner_snapshot' => 'array',
        ];
    }

    public function selectedPartner(): BelongsTo
    {
        return $this->belongsTo(Partner::class, 'selected_partner_id');
    }
}
