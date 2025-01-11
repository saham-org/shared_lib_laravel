<?php

namespace Saham\SharedLibs\Providers;

use Illuminate\Queue\QueueServiceProvider;
use MongoDB\Laravel\Queue\Failed\MongoFailedJobProvider;

class MongodbQueueServiceProvider extends QueueServiceProvider
{
    //  * @inheritdoc
    //  */
    // protected function registerFailedJobServices()
    // {
    //     // Add compatible queue failer if mongodb is configured.
    //     if ($this->app['db']->connection(config('queue.failed.database'))->getDriverName() === 'mongodb') {
    //         $this->app->singleton('queue.failer', static function ($app) {
    //             return new MongoFailedJobProvider($app['db'], config('queue.failed.database'), config('queue.failed.table'));
    //         });
    //     } else {
    //         parent::registerFailedJobServices();
    //     }
    // }
}
