<?php

namespace Saham\SharedLibs\Models\Abstracts;

use Spatie\Permission\Exceptions\PermissionDoesNotExist;

/**
 * Interface PermissionContract.
 */
interface PermissionContract
{
    /**
     * A permission can be applied to roles.
     */
    public function rolesQuery(): ?object;

    /**
     * Find a permission by its name.
     *
     * @param string $name
     * @param string $guardName
     *
     * @throws PermissionDoesNotExist
     *
     * @return PermissionContract
     */
    public static function findByName(string $name, string $guardName): ?self;
}
