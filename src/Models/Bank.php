<?php

namespace Saham\SharedLibs\Models;

use Saham\SharedLibs\Database\Factories\BankFactory;
use Saham\SharedLibs\Models\Abstracts\BaseModel;
use Saham\SharedLibs\Mongodb\Eloquent\SoftDeletes;
use Saham\SharedLibs\Traits\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Bank  extends BaseModel
{
    use HasFactory;
    use Translatable;
    use SoftDeletes ;

    protected $fillable = [
        'name_ar', 'name_en', 'sorting', 'bic', 'type'
    ];
    protected $translatable = ['name'];

    protected static function newFactory()
    {
        return BankFactory::new();
    }

}