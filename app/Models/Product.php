<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'reseller_product_id',
        'name',
        'description',
        'brand',
        'sizes',
        'sku',
        'product_tag',
        'slug',
        'hasStock',
        'profit_margin',
        'price',
        'discount',
        'discount_price',
        'resaler_price',
        'stock',
        'category_id',
    ];
    
}
