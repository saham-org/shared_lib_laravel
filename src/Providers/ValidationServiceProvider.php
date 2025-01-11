<?php

namespace Saham\SharedLibs\Providers;

use Illuminate\Validation\ValidationServiceProvider as BaseProvider;
use Mongodb\Laravel\Validation\DatabasePresenceVerifier;

class ValidationServiceProvider extends BaseProvider
{
    protected function registerPresenceVerifier(): void
    {
        $this->app->singleton('validation.presence', static function ($app) {
            return new DatabasePresenceVerifier($app['db']);
        });
    }
}
