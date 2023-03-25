<?php

namespace SahamLibs\Models;

use SahamLibs\Models\Abstracts\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Cache;

class Setting extends BaseModel
{
    use HasFactory;

    protected static function boot(): void
    {
        parent::boot();

        static::saving(static function (): void {
            Cache::forget('settings');
            Cache::tags('settings')->flush();
        });
    }

    public static function findByKey($key): ?self
    {
        if (Cache::tags(['settings'])->has($key)) {
            return Cache::tags(['settings'])->get($key);
        } else {
            $record = self::where('key', $key)->first();
            Cache::tags(['settings'])->put($key, $record);

            return $record;
        }
    }
}
