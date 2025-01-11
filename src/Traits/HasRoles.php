<?php

namespace Saham\SharedLibs\Traits;

use Illuminate\Support\Collection;
use ReflectionException;
use Saham\SharedLibs\Helpers\PermissionHelpers;
use Saham\SharedLibs\Models\Role;
use MongoDB\Laravel\Eloquent\Builder;
use MongoDB\Laravel\Eloquent\Model;
use Saham\SharedLibs\Registerer\PermissionRegistrar;

use function collect;
use function explode;
use function is_string;

/**
 * Trait HasRoles.
 */
trait HasRoles
{
    use HasPermissions;

    private $roleClass;

    public static function bootHasRoles(): void
    {
        static::deleting(static function (Model $model): void {
            if (isset($model->forceDeleting) && !$model->forceDeleting) {
                return;
            }

            $model->roles()->sync([]);
        });
    }

    public function getRoleClass(): ?object
    {
        if ($this->roleClass === null) {
            $this->roleClass = app(PermissionRegistrar::class)->getRoleClass();
        }

        return $this->roleClass;
    }

    /**
     * A model may have multiple roles.
     */
    public function roles(): mixed
    {
        return $this->belongsToMany('Saham\SharedLibs\Models\Role');
    }

    /**
     * Scope the model query to certain roles only.
     *
     * @param Builder                      $query
     * @param string|array|Role|Collection $roles
     */
    public function scopeRole(Builder $query, $roles): Builder
    {
        $roles = $this->convertToRoleModels($roles);

        return $query->whereIn('role_ids', $roles->pluck('_id'));
    }

    /**
     * Assign the given role to the model.
     *
     * @param array|string|Role ...$roles
     *
     * @throws ReflectionException
     */
    public function assignRole(...$roles): array|Role|string
    {
        $roles = collect($roles)
            ->flatten()
            ->map(function ($role) {
                return $this->getStoredRole($role);
            })
            ->each(function ($role): void {
                $this->ensureModelSharesGuard($role);
            })
            ->all();

        $this->roles()->saveMany($roles);

        $this->forgetCachedPermissions();

        return $roles;
    }

    /**
     * Revoke the given role from the model.
     *
     * @param array|string|Role ...$roles
     */
    public function removeRole(...$roles): array|Role|string
    {
        collect($roles)
            ->flatten()
            ->map(function ($role) {
                $role = $this->getStoredRole($role);
                $this->roles()->detach($role);

                return $role;
            });

        $this->forgetCachedPermissions();

        return $roles;
    }

    /**
     * Remove all current roles and set the given ones.
     *
     * @param array ...$roles
     *
     * @throws ReflectionException
     */
    public function syncRoles(...$roles): Role|array|string
    {
        $this->roles()->sync([]);

        return $this->assignRole($roles);
    }

    /**
     * Determine if the model has (one of) the given role(s).
     *
     * @param string|array|Role|Collection $roles
     */
    public function hasRole($roles = null): bool
    {
        if (is_string($roles) && str_contains($roles, '|')) {
            $roles = explode('|', $roles);
        }

        if (is_string($roles) || $roles instanceof Role) {
            return $this->roles->contains('name', $roles->name ?? $roles);
        }

        $roles = collect()->make($roles)->map(static function ($role) {
            return $role instanceof Role ? $role->name : $role;
        });

        return !$roles->intersect($this->roles->pluck('name'))->isEmpty();
    }

    /**
     * Determine if the model has any of the given role(s).
     *
     * @param string|array|Role|Collection $roles
     */
    public function hasAnyRole($roles): bool
    {
        return $this->hasRole($roles);
    }

    /**
     * Determine if the model has all the given role(s).
     *
     * @param $roles
     */
    public function hasAllRoles(...$roles): bool
    {
        $helpers = new PermissionHelpers();
        $roles   = $helpers->flattenArray($roles);

        foreach ($roles as $role) {
            if (!$this->hasRole($role)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Return Role object.
     *
     * @param string|Role $role role name
     *
     * @throws ReflectionException
     */
    protected function getStoredRole($role): mixed
    {
        if (is_string($role)) {
            return $this->getRoleClass()->findByName($role, $this->getDefaultGuardName());
        }

        return $role;
    }

    /**
     * Return a collection of role names associated with this user.
     *
     * @return Collection<string, string>
     */
    public function getRoleNames(): Collection
    {
        return $this->roles()->pluck('name');
    }

    /**
     * Convert to Role Models.
     *
     * @param $roles
     *
     * @return Collection<string, string>
     */
    private function convertToRoleModels($roles): Collection
    {
        if (is_array($roles)) {
            $roles = collect($roles);
        }

        if (!$roles instanceof Collection) {
            $roles = collect([$roles]);
        }

        return $roles->map(function ($role) {
            return $this->getStoredRole($role);
        });
    }
}
