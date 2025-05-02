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
        $type = $this->faker->randomElement([
            'Footwear', 'Shoes', 'Kicks', 'Athletics', 'Outdoor'
        ]);

        $name = $this->faker->unique()->company.' '.$type;

        return [
            'name' => $name,
            'slug' => Str::slug($name).'-'.Str::lower(Str::random(4)),
            'icon' => 'icons/brands/'.$this->faker->numberBetween(1, 10).'.jpg',
        ];
    }
}
