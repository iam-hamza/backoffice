<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'categories';

    protected $fillable = [
        'name',
        'description',
        'category_id'
    ];

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function subCategories()
    {
        return $this->hasMany(Category::class)->with('categories');
    }
}
