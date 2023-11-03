<?php

namespace Saham\SharedLibs\Database\Factories;

use Saham\SharedLibs\Models\Manager;
use Saham\SharedLibs\Models\Store;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Saham\SharedLibs\Models\Menu;

class MenuFactory extends BaseFactory
{
    protected $model = Menu::class;

    public function definition()
    {
        return [
            'title_ar'         => $this->faker->name(),
            'title_en'         => $this->faker->name(),
            'display_order'    => rand(111, 222),
        ];
    }

    public function withStore(Store $store)
    {
        return $this->state(function (array $attributes) use ($store) {
            return [
                'store_id' => $store->id,
            ];
        });
    }
}
