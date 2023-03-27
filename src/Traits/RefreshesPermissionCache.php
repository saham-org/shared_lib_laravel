<?php

namespace Saham\SharedLibs\Traits;

use Saham\SharedLibs\Models\Permission;

use function app;

/**
 * Trait RefreshesPermissionCache.
 */
trait RefreshesPermissionCache
{
    /**
     * Refresh Permission Cache.
     */
    public static function bootRefreshesPermissionCache(): void
    {
        static::saved(static function (): void {
            app(Permission::class)->forgetCachedPermissions();
        });

        static::deleted(static function (): void {
            app(Permission::class)->forgetCachedPermissions();
        });
    }
}
