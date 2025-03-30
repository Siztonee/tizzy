<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Brand;
use App\Models\Shoe;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ShoeFactory extends Factory
{
    public function definition(): array
    {
        static $imageCounter = 0;
        $imageCounter++;

        $price = $this->faker->randomElement(range(5000, 30000, 1000)); // Round prices from 5000 to 30000
        
        // Only apply discount to some products (about 30%)
        $hasDiscount = $this->faker->boolean(30);
        $discountPercent = $hasDiscount ? $this->faker->numberBetween(10, 80) : null;
        $discountedPrice = $hasDiscount ? round($price * (1 - $discountPercent / 100)) : null;

        $brand = Brand::inRandomOrder()->first();
        $category = Category::inRandomOrder()->first();
        
        // Generate a more realistic name using brand and category
        $shoeTypes = ['Running', 'Walking', 'Casual', 'Sport', 'Classic', 'Lifestyle', 'Performance', 'Training', 'Outdoor'];
        $shoeModels = ['Pro', 'Elite', 'Ultra', 'Air', 'Lite', 'Boost', 'Plus', 'Max', 'Core', 'Prime', 'Flex', 'Swift'];
        
        $name = $brand->name . ' ' . $this->faker->randomElement($shoeTypes) . ' ' . $this->faker->randomElement($shoeModels);
        
        // Add category reference sometimes
        if ($this->faker->boolean(50)) {
            $name .= ' ' . $category->name;
        }
        
        // Add random model number sometimes
        if ($this->faker->boolean(30)) {
            $name .= ' ' . $this->faker->numberBetween(100, 999);
        }
        
        return [
            'category_id' => $category->id,
            'brand_id' => $brand->id,
            'name' => $name,
            'slug' => Str::slug($name),
            'image' => $imageCounter . '.jpg',
            'description' => $this->faker->paragraphs(3, true),
            'price' => $price,
            'discounted_price' => $discountedPrice,
            'discount_percent' => $discountPercent,
            'rating' => $this->faker->randomFloat(1, 3.5, 5.0),
            'active' => true,
        ];
    }
}