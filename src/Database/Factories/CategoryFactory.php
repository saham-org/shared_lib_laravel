<?php

namespace Saham\SharedLibs\Database\Factories;

use Saham\SharedLibs\Models\Enums\CategoryType;
use Illuminate\Database\Eloquent\Factories\Factory;
use Saham\SharedLibs\Models\Category;

class CategoryFactory extends BaseFactory
{
    protected $model = Category::class;


    public function definition()
    {
        $faker_ar = \Faker\Factory::create('ar_AR');
        return [
            'title_ar'   => $faker_ar->company(),
            'title_en'   => $this->faker->company(),
            'desc_ar'    => $faker_ar->text(),
            'desc_en'    => $this->faker->text(),
            'thumb'      => $this->faker->text(),
            'color_code' => $this->faker->hexcolor(),
            'type'       => array_rand(CategoryType::cases()),
        ];
    }
}
