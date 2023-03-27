<?php

namespace Saham\SharedLibs\Middleware;

use Closure;
use Saham\SharedLibs\Helpers\PermissionHelpers;
use Spatie\Permission\Exceptions\UnauthorizedException;

use function explode;
use function is_array;

/**
 * Class RoleMiddleware.
 */
class RoleMiddleware
{
    /**
     * @param $request
     * @param Closure $next
     * @param $role
     *
     * @return mixed
     *
     * @throws UnauthorizedException
     */
    public function handle($request, Closure $next, $role): mixed
    {
        if (app('auth')->guest()) {
            $helpers = new PermissionHelpers();
            throw new UnauthorizedException(403, $helpers->getUserNotLoggedINMessage());
        }

        $roles = is_array($role) ? $role : explode('|', $role);

        if (!app('auth')->user()->hasAnyRole($roles)) {
            $helpers = new PermissionHelpers();
            throw new UnauthorizedException(403, $helpers->getUnauthorizedRoleMessage(implode(', ', $roles)), $roles);
        }

        return $next($request);
    }
}
