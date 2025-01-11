<?php

namespace Saham\SharedLibs\Models;

use Saham\SharedLibs\Models\Abstracts\BaseModel;
use Mongodb\Laravel\Eloquent\SoftDeletes;

class Scene extends BaseModel
{
    use SoftDeletes ;

    protected $fillable = [
        'pitch', 'yaw', 'hfov', 'name', 'compass',
    ];
}
