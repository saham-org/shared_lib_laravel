<?php

namespace SahamLibs\Models;

use SahamLibs\Models\Abstracts\BaseModel;
use SahamLibs\Mongodb\Eloquent\SoftDeletes;
use SahamLibs\Mongodb\Relations\HasMany;
use SahamLibs\Traits\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends BaseModel
{
    use HasFactory;
    use Translatable;
    use SoftDeletes ;

    protected $translatable = ['title'];

    public function stores(): HasMany
    {
        return $this->hasMany(Store::class, 'id', 'category_id');
    }
}
