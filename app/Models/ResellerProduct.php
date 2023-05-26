<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResellerProduct extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'categories',
        'description',
        'brand',
        'displayImages',
        'hasStock',
        'stock',
        'price',
        'name',
        'sizes',
        'sku',
        'slug',
        'currency',
        'status',
        'website',
        'created_at',
        'updated_at',
    ];
}
