<?php

namespace Saham\SharedLibs\Providers;

use Illuminate\Auth\Passwords\PasswordResetServiceProvider as BasePasswordResetServiceProvider;

class PasswordResetServiceProvider extends BasePasswordResetServiceProvider
{
    /**
     * Register the token repository implementation.
     */
    protected function registerTokenRepository(): void
    {
        $this->app->singleton('auth.password.tokens', static function ($app) {
            $connection = $app['db']->connection();

            // The database token repository is an implementation of the token repository
            // interface, and is responsible for the actual storing of auth tokens and
            // their e-mail addresses. We will inject this table and hash key to it.
            $table = $app['config']['auth.password.table'];

            $key = $app['config']['app.key'];

            $expire = $app['config']->get('auth.password.expire', 60);

            return new DatabaseTokenRepository($connection, $table, $key, $expire);
        });
    }

    /**
     * @inheritdoc
     */
    protected function registerPasswordBroker()
    {
        $this->app->singleton('auth.password', static function ($app) {
            return new PasswordBrokerManager($app);
        });

        $this->app->bind('auth.password.broker', static function ($app) {
            return $app->make('auth.password')->broker();
        });
    }
}
