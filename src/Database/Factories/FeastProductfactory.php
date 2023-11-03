<?php

namespace Saham\SharedLibs\Database\Factories;

use Saham\SharedLibs\Models\Menu;
use Saham\SharedLibs\Models\FeastProduct;
use Saham\SharedLibs\Models\Size;

class FeastProductfactory extends BaseFactory
{
    protected $model = FeastProduct::class;

    public function definition()
    {
        return [
            'menu_id'   => '62c2a43e7d0fc177d407d258',
            'title_ar'  => $this->faker->name(),
            'title_en'  => $this->faker->name(),
            'desc_ar'   => $this->faker->text(),
            'desc_en'   => $this->faker->text(),
            'thumb'     => 'https://via.placeholder.com/400',
            'avatar'    => 'https://via.placeholder.com/880',
            'price'     => $this->faker->randomFloat(2, $min = 15.0, $max = 50.9),
            'sizes'     => [],
        ];
    }


    public function forMenu(Menu $menu): ?self
    {
        return $this->state(function (array $attributes) use ($menu) {
            return [
                'menu_id' => $menu->id,
            ];
        });
    }


    public function withPrice(float $price)
    {
        return $this->state(function (array $attributes) use ($price) {
            return [
                'price' => $price,
            ];
        });
    }

}
