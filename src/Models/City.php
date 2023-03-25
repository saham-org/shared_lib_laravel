<?php

namespace SahamLibs\Models;

use SahamLibs\Models\Abstracts\BaseModel;
use SahamLibs\Mongodb\Eloquent\SoftDeletes;
use SahamLibs\Traits\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class City extends BaseModel
{
    use HasFactory;
    use Translatable;
    use SoftDeletes ;

    protected $translatable = ['name'];
}
