<?php

namespace Saham\SharedLibs\Models;

use Saham\SharedLibs\Models\Abstracts\BaseModel;
use Saham\SharedLibs\Traits\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DeliverItem extends BaseModel
{
    use HasFactory;
    use Translatable;

    protected $translatable = ['name'];
}
