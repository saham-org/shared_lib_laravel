<?php

namespace Saham\SharedLibs\Models\Passport;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Passport\Passport;
use Saham\SharedLibs\Mongodb\Eloquent\Model;

class Token extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'oauth_access_tokens';

    /**
     * The "type" of the primary key ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The guarded attributes on the model.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'scopes'  => 'array',
        'revoked' => 'bool',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'expires_at',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get the client that the token belongs to.
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(Passport::clientModel());
    }

    /**
     * Get the user that the token belongs to.
     */
    public function user(): BelongsTo
    {
        $provider = config('auth.guards.api.provider');

        $model = config('auth.providers.' . $provider . '.model');

        return $this->belongsTo($model, 'user_id', (new $model())->getKeyName());
    }

    /**
     * Determine if the token has a given scope.
     *
     * @param string $scope
     */
    public function can($scope): bool
    {
        if (in_array('*', $this->scopes, true)) {
            return true;
        }

        $scopes = Passport::$withInheritedScopes
            ? $this->resolveInheritedScopes($scope)
            : [$scope];

        foreach ($scopes as $scope) {
            if (array_key_exists($scope, array_flip($this->scopes))) {
                return true;
            }
        }

        return false;
    }

    /**
     * Resolve all possible scopes.
     *
     * @param string $scope
     */
    protected function resolveInheritedScopes($scope): mixed
    {
        $parts = explode(':', $scope);

        $partsCount = count($parts);

        $scopes = [];

        for ($i = 1; $i <= $partsCount; ++$i) {
            $scopes[] = implode(':', array_slice($parts, 0, $i));
        }

        return $scopes;
    }

    /**
     * Determine if the token is missing a given scope.
     *
     * @param string $scope
     */
    public function cant($scope): bool
    {
        return !$this->can($scope);
    }

    /**
     * Revoke the token instance.
     */
    public function revoke(): bool
    {
        return $this->forceFill(['revoked' => true])->save();
    }

    /**
     * Determine if the token is a transient JWT token.
     */
    public function transient(): bool
    {
        return false;
    }

    /**
     * Get the current connection name for the model.
     */
    public function getConnectionName(): ?string
    {
        return config('passport.storage.database.connection') ?? $this->connection;
    }
}
