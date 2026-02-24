<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
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
        'status',
    ];
}
