<?php

namespace SahamLibs\Models;

use SahamLibs\Models\Abstracts\BaseModel;
use SahamLibs\Traits\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DeliverItem extends BaseModel
{
    use HasFactory;
    use Translatable;

    protected $translatable = ['name'];
}
