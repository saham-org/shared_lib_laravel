<?php

namespace Saham\SharedLibs\Providers;

use Illuminate\Support\ServiceProvider;
use Mongodb\Laravel\Connection;
use Mongodb\Laravel\Eloquent\Model;
use Mongodb\Laravel\Queue\MongoConnector;

class MongodbServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application events.
     */
    public function boot(): void
    {
        Model::setConnectionResolver($this->app['db']);

        Model::setEventDispatcher($this->app['events']);
    }

    /**
     * Register the service provider.
     */
    public function register(): void
    {
        // Add database driver.
        $this->app->resolving('db', static function ($db): void {
            $db->extend('mongodb', static function ($config, $name) {
                $config['name'] = $name;

                return new Connection($config);
            });
        });

        // Add connector for queue support.
        $this->app->resolving('queue', function ($queue): void {
            $queue->addConnector('mongodb', function () {
                return new MongoConnector($this->app['db']);
            });
        });
    }
}
