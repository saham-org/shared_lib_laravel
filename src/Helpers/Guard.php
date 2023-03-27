<?php

namespace Saham\SharedLibs\Helpers;

use Illuminate\Support\Collection;
use ReflectionClass;
use ReflectionException;

use function get_class;
use function is_object;

/**
 * Class Guard.
 */
class Guard
{
    /**
     * return collection of (guard_name) property if exist on class or object
     * otherwise will return collection of guards names that exist in config/auth.php.
     *
     * @param $model
     *
     * @return Collection <string>
     *
     * @throws ReflectionException
     */
    public function getNames($model): Collection
    {
        $guardName = null;
        $class     = null;

        if (is_object($model)) {
            $guardName = $model->guard_name ?? null;
        }

        if ($guardName === null) {
            $class     = is_object($model) ? get_class($model) : $model;
            $guardName = (new ReflectionClass($class))->getDefaultProperties()['guard_name'] ?? null;
        }

        if ($guardName) {
            return collect($guardName);
        }

        return collect(config('auth.guards'))
            ->map(static function ($guard): ?string {
                if (!isset($guard['provider'])) {
                    return null;
                }

                return config("auth.providers.{$guard['provider']}.model");
            })
            ->filter(static function ($model) use ($class) {
                return $class === $model;
            })
            ->keys();
    }

    /**
     * Return Default Guard name.
     *
     * @param $class
     *
     * @throws ReflectionException
     */
    public function getDefaultName($class): string
    {
        $default = config('auth.defaults.guard');
        return $this->getNames($class)->first() ?: $default;
    }
}
