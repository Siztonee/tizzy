<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categories = [
            'Сапоги',
            'Ботинки',
            'Повседневные',
            'Туфли',
            'Спортивные',
            'Летние',
            'Зимние',
        ];

        $category = $categories[count(Category::all())];

        return [
            'name' => $category,
            'slug' => Str::slug($category),
            'icon' => (count(Category::all()) + 1) . '.jpg'
        ];
    }
}
