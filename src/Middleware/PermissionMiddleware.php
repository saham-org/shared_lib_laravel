<?php

namespace Saham\SharedLibs\Middleware;

use Saham\SharedLibs\Helpers\PermissionHelpers;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Closure;

use function explode;
use function is_array;

/**
 * Class PermissionMiddleware.
 */
class PermissionMiddleware
{
    /**
     * @param $request
     * @param Closure $next
     * @param $permission
     *
     * @return mixed
     *
     * @throws UnauthorizedException
     */
    public function handle($request, Closure $next, $permission): mixed
    {
        if (app('auth')->guest()) {
            $helpers = new PermissionHelpers();
            throw new UnauthorizedException(403, $helpers->getUserNotLoggedINMessage());
        }

        $permissions = is_array($permission) ? $permission : explode('|', $permission);

        if (!app('auth')->user()->hasAnyPermission($permissions)) {
            $helpers = new PermissionHelpers();
            throw UnauthorizedException::forPermissions($permissions);
        }

        return $next($request);
    }
}
