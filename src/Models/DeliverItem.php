<?php

namespace Saham\SharedLibs\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Saham\SharedLibs\Models\Abstracts\BaseModel;
use Saham\SharedLibs\Traits\Translatable;

class DeliverItem extends BaseModel
{
    use HasFactory;
    use Translatable;

    protected $translatable = ['name'];
}
