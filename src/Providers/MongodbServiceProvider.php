<?php

namespace Saham\SharedLibs\Providers;

use Illuminate\Support\ServiceProvider;
use MongoDB\Laravel\Connection;
use MongoDB\Laravel\Eloquent\Model;
use MongoDB\Laravel\MongoDBServiceProvider as LaravelMongoDBServiceProvider;
use MongoDB\Laravel\Queue\MongoConnector;

class MongodbServiceProvider extends LaravelMongoDBServiceProvider
{
}
