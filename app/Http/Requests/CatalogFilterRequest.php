<?php

namespace App\Http\Requests;

use App\Models\Brand;
use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

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
    public function rules()
    {
        return [
            'brands' => 'nullable|string',
            'categories' => 'nullable|string',
            'min_price' => 'nullable|numeric|min:0',
            'max_price' => 'nullable|numeric|min:0',
            'discount' => 'nullable|integer|between:0,100',
            'sort' => 'nullable|in:price_asc,price_desc,newest',
            'page' => 'nullable|integer'
        ];
    }

    public function validated($key = null, $default = null)
    {
        $data = parent::validated();

        $data['brands'] = isset($data['brands']) 
            ? explode(',', $data['brands'])
            : [];

        $data['categories'] = isset($data['categories']) 
            ? explode(',', $data['categories'])
            : [];

        $this->checkSlugsExist($data['brands'], Brand::class, 'slug');
        $this->checkSlugsExist($data['categories'], Category::class, 'slug');

        return $key ? ($data[$key] ?? $default) : $data;
    }

    private function checkSlugsExist(array $slugs, string $model, string $column)
    {
        if (count($slugs) > 0) {
            $existing = $model::whereIn($column, $slugs)->pluck($column);
            $nonExisting = array_diff($slugs, $existing->toArray());

            if (count($nonExisting)) {
                throw ValidationException::withMessages([
                    $column => "Некорректные значения: " . implode(', ', $nonExisting)
                ]);
            }
        }
    }
}
