<?php

namespace Saham\SharedLibs\Traits;

use Auth;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Saham\SharedLibs\Models\Activity;
use MongoDB\Laravel\Eloquent\Model;

trait Trackable
{
    protected static $blackListedModels = [
        'Saham\SharedLibs\Models\Activity',
        'Saham\SharedLibs\Models\PasswordReset',
        'Saham\SharedLibs\Models\Messages',
        'Saham\SharedLibs\Models\ProductVariation',
        'Saham\SharedLibs\Models\Product',
        'Saham\SharedLibs\Models\Menu',
        'Saham\SharedLibs\Models\Cuisine',
        'Saham\SharedLibs\Models\Bank',
        'Saham\SharedLibs\Models\DatabaseNotification',

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
            'guard_name'     => FacadesAuth::getDefaultDriver(),
            'subject'        => get_class($model),
            'causer'         => auth()->user()?->id ?? null,
            // 'properties'     => request()->except('_method', '_token'),
            'old_properties' => $model->getOriginal(),
            'date'           => date('Y-m-d'),
        ];
        Activity::create($data);
    }
}
