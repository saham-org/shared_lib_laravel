<?php

namespace Saham\SharedLibs\Models;

use Saham\SharedLibs\Models\Abstracts\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Cache;

class Setting extends BaseModel
{
    use HasFactory;

    protected static function boot(): void
    {
        parent::boot();
    }

    public static function findByKey($key): mixed
    {
        $record = self::where('key', $key)->first();

        return $record;
    }
}
