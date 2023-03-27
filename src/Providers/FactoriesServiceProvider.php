<?php

namespace Saham\SharedLibs\Providers;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\ServiceProvider;

class FactoriesServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // $this->registerEloquentFactoriesFrom(__DIR__ . '/../Database/Factories');

        Factory::guessFactoryNamesUsing(function (string $modelName) {
            return 'Saham\\SharedLibs\\Database\\Factories\\'.class_basename($modelName).'Factory';
        });
    }


    protected function registerEloquentFactoriesFrom($path)
    {
        // $this->app->make(Factory::class)->load($path);
    }
}
