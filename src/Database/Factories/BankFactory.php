<?php

namespace Saham\SharedLibs\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BankFactory extends BaseFactory
{
    public function definition()
    {
        $faker_ar = \Faker\Factory::create('ar_AR');
        return [
            'name_en'   => $this->faker->text(),
            'name_ar'   => $this->faker->text(),
            'bic'   => $this->faker->text(),
            'type'   => $this->faker->text(),
        ];
    }
}
