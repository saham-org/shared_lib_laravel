<?php

namespace Saham\SharedLibs\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Saham\SharedLibs\Database\Factories\CounterFactory;
use Saham\SharedLibs\Models\Abstracts\BaseModel;

class Counter extends BaseModel
{
    use HasFactory;

    protected static function newFactory()
    {
        return CounterFactory::new();
    }
}
