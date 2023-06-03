<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddResellerProductsToProducts extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
        
                'reseller_product_id' => 'nullable|integer',
                'name' => 'nullable|string',
                'description' => 'nullable|string',
                'brand' => 'nullable|string',
                'sizes' => 'nullable',
                'sku' => 'nullable|string',
                'product_tag' => 'nullable',
                'slug' => 'nullable|string',
                'hasStock' => 'nullable|boolean',
                'profit_margin' => 'nullable|integer',
                'price' => 'nullable|numeric',
                'discount' => 'nullable|integer',
                'discount_price' => 'nullable|numeric',
                'resaler_price' => 'nullable|numeric',
                'stock' => 'nullable|integer',
                'category_id' => 'nullable|integer',
           
        ];
    }
}
