<?php

namespace Saham\SharedLibs\Providers;

use Illuminate\Support\ServiceProvider;
use Mongodb\Laravel\Connection;
use Mongodb\Laravel\Eloquent\Model;
use MongoDB\Laravel\MongoDBServiceProvider as LaravelMongoDBServiceProvider;
use Mongodb\Laravel\Queue\MongoConnector;

class MongodbServiceProvider extends LaravelMongoDBServiceProvider
{
}
