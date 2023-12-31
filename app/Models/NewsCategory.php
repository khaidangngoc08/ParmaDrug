<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsCategory extends Model
{
    use HasFactory;
    protected $table = 'new_categories';

    protected $fillable = [
        'name',
        'slug',
        'is_open',
        'user_id'
    ];

}
