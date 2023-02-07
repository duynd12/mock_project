<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddProductRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            // 'categories' => 'required',
            'price' => 'required|integer|min:1000',
            'description' => 'required|string',
            'quantity' => 'required|integer|min:0',
            'discount' => 'between:0,100',
            'images.*' => 'required|mimes:jpeg,jpg,png|max:5120'
        ];
    }
}
