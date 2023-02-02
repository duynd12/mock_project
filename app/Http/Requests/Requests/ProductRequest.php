<?php

namespace App\Http\Requests\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|unique:products',
            'price' => 'required|numeric|gt:0',
            'quantity' => 'required|numeric|gt:0',
            'description' => 'required|',
            'categories' => 'required',
            'colors' => 'required',
            'sizes' => 'required',
            'images' => 'required|image|mimes:jpeg,png,jpg',
        ];
    }
}
