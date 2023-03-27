<?php

namespace Saham\SharedLibs\Models;

use Saham\SharedLibs\Models\Abstracts\BaseModel;
use Saham\SharedLibs\Traits\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Saham\SharedLibs\Database\Factories\SizeFactory;

class Size extends BaseModel
{
    use HasFactory;
    use Translatable;

    public $timestamps      = false;
    protected $translatable = ['title'];


    protected static function newFactory()
    {
        return SizeFactory::new();
    }
}
