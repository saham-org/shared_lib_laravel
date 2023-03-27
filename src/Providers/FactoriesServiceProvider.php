<?php

namespace Saham\SharedLibs\Providers;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\ServiceProvider;

class FactoriesServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->registerEloquentFactoriesFrom(__DIR__ . '/../Database/Factories');
    }


    protected function registerEloquentFactoriesFrom($path)
    {
        $this->app->make(Factory::class)->load($path);
    }
}
