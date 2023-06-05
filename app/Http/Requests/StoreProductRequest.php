<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'reseller_product_id' => 'nullable|numeric',
            'name' => 'required|string',
            'description' => 'nullable|string',
            'brand' => 'nullable|string',
            'sizes' => 'nullable|string',
            'sku' => 'nullable|string',
            'product_tag' => 'nullable|string',
            'slug' => 'nullable|string',
            'hasStock' => 'required|boolean',
            'profit_margin' => 'required|numeric',
            'price' => 'required|numeric',
            'discount' => 'nullable|numeric',
            'discount_price' => 'nullable|numeric',
            'resaler_price' => 'nullable|numeric',
            'stock' => 'required|integer',
            'category_id' => 'nullable|numeric',
            'images' => 'nullable|array',
            'images.*' => 'image|max:2048',
        ];
    }
}
