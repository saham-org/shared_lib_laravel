<?php

namespace Saham\SharedLibs\Models;

use Saham\SharedLibs\Models\Abstracts\BaseModel;
use Saham\SharedLibs\Mongodb\Eloquent\SoftDeletes;
use Saham\SharedLibs\Traits\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class City extends BaseModel
{
    use HasFactory;
    use Translatable;
    use SoftDeletes ;

    protected $translatable = ['name'];
}
