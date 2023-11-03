<?php

namespace Saham\SharedLibs\Database\Factories;

use Saham\SharedLibs\Models\Enums\CategoryType;
use Illuminate\Database\Eloquent\Factories\Factory;

class CityFactory extends BaseFactory
{
    public function definition()
    {

        $faker_ar = \Faker\Factory::create('ar_AR');
        return [
            'name_en'   => $this->faker->text(),
            'name_ar'   => $this->faker->text(),
            'latitude'            => $this->faker->latitude(),
            'longitude'           => $this->faker->longitude(),
        ];
    }
}
