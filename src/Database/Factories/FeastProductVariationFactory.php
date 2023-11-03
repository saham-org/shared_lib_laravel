<?php

namespace Saham\SharedLibs\Database\Factories;

use Saham\SharedLibs\Models\FeastProduct;
use Saham\SharedLibs\Models\ProductVariation;

class FeastProductVariationFactory extends BaseFactory
{
    protected $model = ProductVariation::class;


    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'product_id' => FeastProduct::raw(function ($collection) {
                return $collection->aggregate([['$sample' => ['size' => 1]]]);
            })[0]['_id'],

            'type'       => 'multi',
            'title_ar'   => $this->faker->name(),
            'title_en'   => $this->faker->name(),
            'max'        => $this->faker->randomDigit(),
            'min'        => $this->faker->randomDigit()
        ];
    }
}
