<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;
    protected $table = 'news';
    protected $fillable = [
        'name',
        'avatar',
        'description',
        'keyword',
        'content',
        'is_open',
        'user_id',
        'new_category_id',
    ];

    public function news_category()
    {
        return $this->belongsTo('\App\Models\NewsCategory', 'new_category_id', 'id');
    }

}
