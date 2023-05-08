<?php

namespace Saham\SharedLibs\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Saham\SharedLibs\Mongodb\Relations\HasMany;

class Feast extends Order
{
    use HasFactory;

    protected $table = 'feasts';

    public function details(): HasMany
    {
        return $this->hasMany(FeastDetails::class);
    }
}
