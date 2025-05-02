<?php

namespace Database\Factories;

use App\Models\Shoe;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class ShoeFactory extends Factory
{
    public function definition(): array
    {
        static $imageCounter = 0;
        static $brandIds = null;
        static $categoryIds = null;

        // Инициализируем ID один раз для всех экземпляров
        if ($brandIds === null) {
            $brandIds = Brand::pluck('id')->toArray();
        }
        if ($categoryIds === null) {
            $categoryIds = Category::pluck('id')->toArray();
        }

        $imageCounter++;

        $price = $this->faker->randomElement(range(1000, 50000, 1000));
        
        // Логика скидки
        $hasDiscount = $this->faker->boolean(30);
        $discountDates = $hasDiscount ? [
            'discount_start' => Carbon::now()->subDays($this->faker->numberBetween(1, 7)),
            'discount_end' => Carbon::now()->addDays($this->faker->numberBetween(7, 30)),
        ] : [];

        $shoeTypes = ['Running', 'Walking', 'Casual', 'Sport', 'Classic'];
        $shoeModels = ['Pro', 'Elite', 'Ultra', 'Air', 'Lite'];
        
        $name = $this->faker->randomElement($shoeTypes).' '.
                $this->faker->randomElement($shoeModels).' '.
                $this->faker->unique()->numberBetween(100, 999);

        return array_merge([
            'category_id' => $this->faker->randomElement($categoryIds),
            'brand_id' => $this->faker->randomElement($brandIds),
            'name' => $name,
            'slug' => Str::slug($name).'-'.Str::lower(Str::random(6)),
            'image' => 'products/'.($imageCounter % 10 + 1).'.jpg',
            'description' => $this->faker->paragraphs(3, true),
            'stock_count' => $this->faker->numberBetween(0, 1000),
            'price' => $price,
            'discounted_price' => $hasDiscount ? round($price * (1 - $this->faker->numberBetween(10, 80)/100)) : null,
            'discount_percent' => $hasDiscount ? $this->faker->numberBetween(10, 80) : null,
            'rating' => $this->faker->randomFloat(1, 0, 5),
            'is_active' => $this->faker->boolean(90),
            'created_at' => $this->faker->dateTimeBetween('-2 years'),
        ], $discountDates);
    }
}