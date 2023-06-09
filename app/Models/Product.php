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
        'status'
    ];

    const status=[
        1=>'Live',
        2=>'Removed',
    ];

 /**
     * Date of the order event 
     * 
     * hasMany
     */
    public function images() 
    {
        return $this->hasMany(ProductImage::class);
    }

    public function category() 
    {
        return $this->belongsTo(Category::class);
    }
    
}
