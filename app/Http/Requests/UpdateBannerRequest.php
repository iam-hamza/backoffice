<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBannerRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'banner_type' => 'required',
            'image' => 'nullable',
            'title' => 'nullable',
            'body' => 'nullable',
        ];
    }
}
