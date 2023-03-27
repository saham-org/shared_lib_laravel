<?php

namespace Saham\SharedLibs\Models\Passport;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Passport\Passport;

class PersonalAccessClient extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'oauth_personal_access_clients';

    /**
     * The guarded attributes on the model.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Get all of the authentication codes for the client.
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(Passport::clientModel());
    }

    /**
     * Get the current connection name for the model.
     */
    public function getConnectionName(): ?string
    {
        return config('passport.storage.database.connection') ?? $this->connection;
    }
}
