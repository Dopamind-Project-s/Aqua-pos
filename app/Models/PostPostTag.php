<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostPostTag extends Model
{
    use HasFactory;

    protected $table = 'post_post_tag';

    public $timestamps = false;

    protected $fillable = [
        'post_id',
        'post_tag_id',
    ];
}
