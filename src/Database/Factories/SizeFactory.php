<?php

namespace Saham\SharedLibs\Database\Factories;

use Saham\SharedLibs\Models\Partner;
use Saham\SharedLibs\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class SizeFactory extends BaseFactory
{
    public function definition()
    {
        return [

            'title_ar'          => $this->faker->name(),
            'title_en'          => $this->faker->name(),
            'price'             => 15,
            '_id'               => $this->faker->uuid(),
        ];
    }


    public function forProduct(Product $product)
    {
        return $this->state(function (array $attributes) use ($product) {
            return [
                'product_id' => $product->id,
            ];
        });
    }
}
