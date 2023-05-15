<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
  /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name'=>'required|string',
            'description'=>'nullable|string',
            'category_id'=>'required|numeric|exists:categories,id',
            'price'=>'required|numeric',
            'images'=>'nullable'
        ];
    }

    public function prepareRequest()
    {
        $request = $this;
        $data = [
            'name'=>$request['name'],
            'category_id'=>$request['category_id'],
        ];
        if(isset($request['description']) && $request['description']) {
            $data['description'] = $request['description'];
        }
        if(isset($request['images']) && $request['images']) {
            $data['images'] = $request['images'];
        }
        if(isset($request['description']) && $request['description']) {
            $data['description'] = $request['description'];
        }
        if(isset($request['brand']) && $request['brand']) {
            $data['brand'] = $request['brand'];
        }
        if(isset($request['hasStock']) && $request['hasStock']) {
            $data['hasStock'] = $request['hasStock'];
        }
        if(isset($request['slug']) && $request['slug']) {
            $data['slug'] = $request['slug'];
        }
        if(isset($request['sku']) && $request['sku']) {
            $data['sku'] = $request['sku'];
        }
        if(isset($request['price']) && $request['price']) {
            $data['price'] = $request['price'];
        }
        if(isset($request['discount']) && $request['discount']) {
            $data['discount'] = $request['discount'];
        }
        if(isset($request['resaler_price']) && $request['resaler_price']) {
            $data['resaler_price'] = $request['resaler_price'];
        }
        if(isset($request['resaler_price']) && $request['resaler_price']) {
            $data['resaler_price'] = $request['resaler_price'];
        }
        if(isset($request['stock']) && $request['stock']) {
            $data['stock'] = $request['stock'];
        }

        return $data;
    }
}
