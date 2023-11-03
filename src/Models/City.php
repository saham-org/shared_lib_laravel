<?php

namespace Saham\SharedLibs\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Saham\SharedLibs\Database\Factories\CityFactory;
use Saham\SharedLibs\Models\Abstracts\BaseModel;
use Saham\SharedLibs\Mongodb\Eloquent\SoftDeletes;
use Saham\SharedLibs\Traits\Translatable;

class City extends BaseModel
{
    use HasFactory;
    use Translatable;
    use SoftDeletes ;

    protected $fillable = [
        'name_ar', 'name_en', 'sorting', 'latitude', 'longitude', 'phone_code',
    ];
    protected $translatable = ['name'];

    protected static function newFactory()
    {
        return CityFactory::new();
    }
}
