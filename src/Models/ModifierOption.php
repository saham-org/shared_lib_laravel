<?php

namespace Saham\SharedLibs\Models;

use Saham\SharedLibs\Models\Abstracts\BaseModel;
use Saham\SharedLibs\Traits\Translatable;

class ModifierOption  extends BaseModel
{
    use HasFactory;
    use Translatable;

    public $timestamps      = false;
    protected $translatable = ['title'];
}
