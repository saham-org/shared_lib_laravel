<?php

namespace Saham\SharedLibs\Models;

use Saham\SharedLibs\Models\Abstracts\BaseModel;
use Saham\SharedLibs\Mongodb\Relations\HasMany;

class Unit extends BaseModel
{
    public function slots(): HasMany
    {
        return $this->hasMany(Slot::class);
    }
}
