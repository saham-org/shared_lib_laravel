<?php

namespace Saham\SharedLibs\Database\Factories;

use Saham\SharedLibs\Models\Cuisine;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Cuisine>
 */
class CuisineFactory extends BaseFactory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name_ar'  => 'عربي',
            'name_en'  => 'Arabian',
        ];
    }
}
