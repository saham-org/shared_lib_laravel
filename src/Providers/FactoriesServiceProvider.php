<?php

namespace Saham\SharedLibs\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;

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
