<?php

namespace Saham\SharedLibs\Models;

use Saham\SharedLibs\Models\Abstracts\BaseModel;
use Saham\SharedLibs\Mongodb\Eloquent\SoftDeletes;

class Scene extends BaseModel
{

    use SoftDeletes ;

    protected $fillable = [
        'pitch', 'yaw', 'hfov', 'name', 'compass'
    ];

}
