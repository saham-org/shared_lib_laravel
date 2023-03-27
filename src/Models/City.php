<?php

namespace Saham\SharedLibs\Models;

use Saham\SharedLibs\Models\Abstracts\BaseModel;
use Saham\SharedLibs\Mongodb\Eloquent\SoftDeletes;
use Saham\SharedLibs\Traits\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Saham\SharedLibs\Database\Factories\CityFactory;

class City extends BaseModel
{
    use HasFactory;
    use Translatable;
    use SoftDeletes ;

    protected static function newFactory()
    {
        return CityFactory::new();
    }

    protected $translatable = ['name'];
}
