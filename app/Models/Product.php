<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProductImage;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'products';

    protected $fillable = [
        'name',
        'description',
        'brand',
        'sizes',
        'price',
        'sku',
        'slug',
        'hasStock',
        'discount',
        'resaler_price',
        'stock',
        'category_id',
    ];

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }
}
