<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'products';

    protected $fillable = [
        'name',
        'description',
        'content',
        'avatar',
        'product_category_id',
        'price',
    ];

    public function product_category()
    {
        return $this->belongsTo('\App\Models\ProductCategory', 'product_category_id', 'id');
    }



}
