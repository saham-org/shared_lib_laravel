<?php

namespace SahamLibs\Traits;

use SahamLibs\Models\Activity;
use SahamLibs\Mongodb\Eloquent\Model;
use Auth;

trait Trackable
{
    protected static $blackListedModels = [
        'SahamLibs\Models\Activity',
        'SahamLibs\Models\PasswordReset',
        'SahamLibs\Models\Messages',
        'SahamLibs\Models\ProductVariation',
        'SahamLibs\Models\Product',
        'SahamLibs\Models\Menu',
        'SahamLibs\Models\Cuisine',
    ];

    public static function bootTrackable(): void
    {
        static::created(static function ($model): void {
            self::createActivity($model, 'create');
        });

        static::updated(static function ($model): void {
            self::createActivity($model, 'updated');
        });

        static::deleted(static function ($model): void {
            self::createActivity($model, 'deleted');
        });
    }

    public static function createActivity(Model $model, $event = 'create'): void
    {
        if (in_array(get_class($model), self::$blackListedModels, true)) {
            return;
        }

        $data = [
            'event'          => $event,
            'related_id'     => $model->id,
            'related_type'   => get_class($model),
            'guard_name'     => Auth::getDefaultDriver(),
            'subject'        => get_class($model),
            'causer'         => auth()->user()?->id ?? null,
            // 'properties'     => request()->except('_method', '_token'),
            'old_properties' => $model->getOriginal(),
            'date'           => date('Y-m-d'),
        ];
        Activity::create($data);
    }
}
