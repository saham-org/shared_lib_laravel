<?php

namespace Saham\SharedLibs\Registerer;

use Saham\SharedLibs\Models\Permission;
use Saham\SharedLibs\Models\Role;
use Illuminate\Contracts\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Contracts\Cache\Repository;
use Illuminate\Support\Collection;

/**
 * Class PermissionRegistrar.
 */
class PermissionRegistrar
{
    protected Gate $gate;

    protected Repository $cache;

    protected string $cacheKey = 'permission.cache';

    protected string $permissionClass;

    protected string $roleClass;

    /**
     * PermissionRegistrar constructor.
     *
     * @param Gate       $gate
     * @param Repository $cache
     */
    public function __construct(Gate $gate, Repository $cache)
    {
        $this->gate            = $gate;
        $this->cache           = $cache;
        $this->permissionClass =  Permission::class;
        $this->roleClass       = Role::class;
    }

    /**
     * Register Permissions.
     */
    public function registerPermissions(): bool
    {
        $this->getPermissions()->map(function (Permission $permission): void {
            $this->gate->define($permission->name, static function (Authorizable $user) use ($permission) {
                return $user->hasPermissionTo($permission) ?: null;
            });
        });

        return true;
    }

    /**
     * Forget cached permission.
     */
    public function forgetCachedPermissions(): void
    {
        $this->cache->forget($this->cacheKey);
    }

    /**
     * Get Permissions.
     *
     * @return Collection <string, string>
     */
    public function getPermissions(): Collection
    {
        return $this->cache->remember($this->cacheKey, config('permission.cache_expiration_time'), function () {
            return $this->getPermissionClass()->get();
        });
    }

    /**
     * Get Permission class.
     */
    public function getPermissionClass(): mixed
    {
        return app($this->permissionClass);
    }

    /**
     * Get Role class.
     */
    public function getRoleClass(): mixed
    {
        return app($this->roleClass);
    }
}
