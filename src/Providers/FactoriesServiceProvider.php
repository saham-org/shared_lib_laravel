<?php

namespace Saham\SharedLibs\Providers;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class FactoriesServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Factory::guessFactoryNamesUsing(static function (string $modelName) {
            // We can also customise where our factories live too if we want:
            $namespace = 'Saham\\SharedLibs\\Database\\Factories\\';

            // Here we are getting the model name from the class namespace
            $modelName = Str::afterLast($modelName, '\\');

            // Finally we'll build up the full class path where
            // Laravel will find our model factory
            return $namespace . $modelName . 'Factory';
        });


        Factory::useNamespace('Saham\\SharedLibs\\Models\\');
    }
}
