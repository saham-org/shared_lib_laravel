<?php

namespace Saham\SharedLibs\Database\Factories;

use Saham\SharedLibs\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use MongoDB\BSON\UTCDateTime;

class BaseFactory extends Factory
{
    protected static function appNamespace()
    {
        return 'Saham\\SharedLibs\\Models\\';
    }

    public function definition()
    {
        return [];
    }
}
