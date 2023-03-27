<?php

namespace Saham\SharedLibs\Models;

use Saham\SharedLibs\Models\Abstracts\BaseModel;
use Saham\SharedLibs\Traits\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Saham\SharedLibs\Database\Factories\CuisineFactory;

class Cuisine extends BaseModel
{
    use HasFactory;
    use Translatable;

    protected static function newFactory()
    {
        return CuisineFactory::new();
    }


    protected $translatable = ['name'];
}
