<?php

namespace Saham\SharedLibs\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Saham\SharedLibs\Models\Banner;

class BannerFactory extends Factory
{
    protected $model = Banner::class;

    public function definition()
    {
        return [

            'thumb'      => 'https://via.placeholder.com/400',
            'image'      => 'https://via.placeholder.com/880',
        ];
    }
}
