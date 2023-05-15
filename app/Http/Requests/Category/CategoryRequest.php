<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
            'category_id'=>'nullable|numeric|exists:categories,id',
        ];
    }

    public function prepareRequest()
    {
        $request = $this;
        $data = [
            'name'=>$request['name'],
            'description'=>$request['description']
        ];
        if(isset($request['category_id']) && $request['category_id']) {
            $data['category_id'] = $request['category_id'];
        }
        return $data;
        
    }
}
