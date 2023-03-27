<?php

namespace Saham\SharedLibs\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BannerFactory extends Factory
{
    public function definition()
    {
        $faker_ar = \Faker\Factory::create('ar_AR');
        return [

            'thumb'      => 'https://via.placeholder.com/400',
            'image'      => 'https://via.placeholder.com/880',
        ];
    }
}
