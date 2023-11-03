<?php

namespace Saham\SharedLibs\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Saham\SharedLibs\Models\Abstracts\BaseModel;

class Setting extends BaseModel
{
    use HasFactory;

    protected static function boot(): void
    {
        parent::boot();
    }

    public static function findByKey($key): mixed
    {
        return self::where('key', $key)->first();
    }
}
