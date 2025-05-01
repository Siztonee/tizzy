<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CatalogFilterRequest extends FormRequest
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
            'categories' => 'nullable|array',
            'categories.*' => 'integer|exists:categories,id',
            'brands' => 'nullable|array',
            'brands.*' => 'integer|exists:brands,id',
            'min_price' => 'nullable|numeric|min:0',
            'max_price' => 'nullable|numeric|min:0|gte:min_price',
            'discount' => 'nullable|integer|min:0|max:100',
            'sort' => 'nullable|in:price_asc,price_desc,newest',
            'page' => 'nullable|integer'
        ];
    }
}
