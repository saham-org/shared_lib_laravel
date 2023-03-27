<?php

namespace Saham\SharedLibs\Providers;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\ServiceProvider;

class FactoriesServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Factory::guessFactoryNamesUsing(function (string $modelName) {
        //     return 'Saham\\SharedLibs\\Database\\Factories\\'.class_basename($modelName).'Factory';
        // });
    }
}
