<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostCategoryPost extends Model
{
    use HasFactory;

    protected $table = 'post_category_post';

    public $timestamps = false;

    protected $fillable = [
        'post_id',
        'post_category_id',
    ];
}
