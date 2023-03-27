<?php

namespace Saham\SharedLibs\Helpers;

use Illuminate\Support\Collection;

use function collect;
use function config;

/**
 * Class Helpers.
 */
class PermissionHelpers
{
    public function getModelForGuard(string $guard): ?string
    {
        return collect(config('auth.guards'))
            ->map(static function ($guard) {
                return config("auth.providers.{$guard['provider']}.model");
            })->get($guard);
    }

    public function getGuardDoesNotMatchMessage(Collection $expected, string $given): string
    {
        $expectedStr = $expected->implode(', ');
        return "The given role or permission should use guard `$expectedStr` instead of `$given`.";
    }

    public function getPermissionAlreadyExistsMessage(string $name, string $guardName): string
    {
        return "A permission `$name` already exists for guard `$guardName`.";
    }

    public function getPermissionDoesNotExistMessage(string $name, string $guardName): string
    {
        return "There is no permission named `$name` for guard `$guardName`.";
    }

    public function getRoleAlreadyExistsMessage(string $name, string $guardName): string
    {
        return "A role `$name` already exists for guard `$guardName`.";
    }

    public function getRoleDoesNotExistMessage(string $name, string $guardName): string
    {
        return "There is no role named `$name` for guard `$guardName`.";
    }

    public function getUnauthorizedRoleMessage(string $roles): string
    {
        $message = "User does not have the right roles `$roles`.";

        if (!config('permission.display_permission_in_exception')) {
            $message = 'User does not have the right roles.';
        }

        return $message;
    }

    public function getUnauthorizedPermissionMessage(string $permissions): string
    {
        $message = "User does not have the right permissions `$permissions`.";

        if (!config('permission.display_permission_in_exception')) {
            $message = 'User does not have the right permissions.';
        }

        return $message;
    }

    public function getUserNotLoggedINMessage(): string
    {
        return 'User is not logged in.';
    }

    public function isNotLumen(): bool
    {
        return !(stripos(app()->version(), 'lumen') !== false);
    }

    public function checkVersion(): bool
    {
        return $this->isNotLumen() && app()::VERSION < '5.4';
    }

    /**
     * @param array $items
     *
     * @return array<string, string>
     */
    public function flattenArray(array $items): array
    {
        return collect($items)->map(static function ($item) {
            return is_string($item) ? explode('|', $item) : $item;
        })->flatten()->all();
    }
}
