<?php

namespace Saham\SharedLibs\Mongodb\Validation;

use Illuminate\Validation\ValidationServiceProvider as BaseProvider;

class ValidationServiceProvider extends BaseProvider
{
    protected function registerPresenceVerifier()
    {
        $this->app->singleton('validation.presence', function ($app) {
            return new DatabasePresenceVerifier($app['db']);
        });
    }
}
