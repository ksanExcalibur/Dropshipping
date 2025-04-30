<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word(),
            'qty' => $this->faker->numberBetween(1, 100),
            'description' => $this->faker->sentence(),
            'price' => $this->faker->randomFloat(2, 1, 1000),
            'image' => 'products/default.jpg',
            'category_id' => function () {
                return \App\Models\Category::factory()->create()->id;
            },
        ];
    }
}