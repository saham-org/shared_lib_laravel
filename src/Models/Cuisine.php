<?php

namespace SahamLibs\Models;

use SahamLibs\Models\Abstracts\BaseModel;
use SahamLibs\Traits\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cuisine extends BaseModel
{
    use HasFactory;
    use Translatable;

    protected $translatable = ['name'];
}
