<?php

namespace Saham\SharedLibs\Models;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Saham\SharedLibs\Models\Abstracts\BaseModel;
use Saham\SharedLibs\Mongodb\Eloquent\SoftDeletes;
use Saham\SharedLibs\Traits\Translatable;


class Zone   extends BaseModel
{
    use HasFactory;
    use SoftDeletes ;
    use Translatable;
    protected $guarded = [];
    protected $table = 'zones';
    protected $translatable = ['name'] ;


}