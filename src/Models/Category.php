<?php

namespace Saham\SharedLibs\Models;

use Saham\SharedLibs\Models\Abstracts\BaseModel;
use Saham\SharedLibs\Mongodb\Eloquent\SoftDeletes;
use Saham\SharedLibs\Mongodb\Relations\HasMany;
use Saham\SharedLibs\Traits\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Saham\SharedLibs\Database\Factories\CategoryFactory;

class Category extends BaseModel
{
    use HasFactory;
    use Translatable;
    use SoftDeletes ;

    protected static function newFactory()
    {
        return CategoryFactory::new();
    }

    protected $translatable = ['title'];

    public function stores(): HasMany
    {
        return $this->hasMany(Store::class, 'id', 'category_id');
    }
}
