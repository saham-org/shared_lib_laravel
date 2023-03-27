<?php

namespace Saham\SharedLibs\Models;

use Saham\SharedLibs\Models\Abstracts\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Saham\SharedLibs\Database\Factories\CityFactory;
use Saham\SharedLibs\Database\Factories\CounterFactory;

class Counter extends BaseModel
{
    use HasFactory;


    protected static function newFactory()
    {
        return CounterFactory::new();
    }
}
