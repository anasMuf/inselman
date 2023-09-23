<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */

    protected $model = Product::class;

    public function definition()
    {
        return [
            'product_name' => $this->faker->company,
            'description' => $this->faker->realText,
            'selling_price' => $this->faker->numberBetween(150000,300000),
            'stock' => $this->faker->numberBetween(10,50),
            'sku' => $this->faker->ean8,
        ];
    }
}
