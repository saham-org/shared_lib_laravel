<?php

namespace Saham\SharedLibs\Models\Passport;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Passport\Passport;
use Laravel\Passport\RefreshToken as PassportRefreshToken;
use Saham\SharedLibs\Mongodb\Eloquent\Model;

class RefreshToken extends PassportRefreshToken
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'oauth_refresh_tokens';
    protected $connection = 'authmongodb';

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
     * Get the access token that the refresh token belongs to.
     */
    public function accessToken(): BelongsTo
    {
        return $this->belongsTo(Passport::tokenModel());
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
