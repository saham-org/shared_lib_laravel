<?php

namespace Saham\SharedLibs\Models\Passport;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Passport\PersonalAccessClient as PassportPersonalAccessClient;
use Laravel\Passport\Passport;
use Saham\SharedLibs\Mongodb\Eloquent\Model as Eloquent;


class PersonalAccessClient extends Eloquent
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'oauth_personal_access_clients';
    protected $connection = 'authmongodb';

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
        return   $this->connection;
    }
}
