<?php

namespace Database\Factories;

use App\Models\Brand;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Brand>
 */
class BrandFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $brands = [
            'Nike',
            'Adidas', 
            'Puma', 
            'New Balance', 
            'Reebok'
        ];

        $brand = $brands[count(Brand::all())];

        return [
            'name' => $brand,
            'slug' => Str::slug($brand),
            'icon' => (count(Brand::all()) + 1) . '.jpg'
        ];
    }
}
