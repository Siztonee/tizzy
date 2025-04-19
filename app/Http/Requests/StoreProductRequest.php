<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:512',
            'price' => 'required|numeric|min:0',
            'image' => 'required|image|mimes:png,jpg,jpeg, img|max:3020',
            'discount_percent' => 'required|numeric|between:0,100',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'stock_count' => 'required|numeric|min:1',
        ];
    }

    public function messages(): array
    {
        return [
            'image.max' => 'Изображение должно быть меньше 3 МБ',
        ];
    }
}
