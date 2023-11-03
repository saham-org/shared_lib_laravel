<?php

namespace Saham\SharedLibs\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Saham\SharedLibs\Models\Abstracts\BaseModel;
use Saham\SharedLibs\Mongodb\Eloquent\SoftDeletes;
use Saham\SharedLibs\Mongodb\Relations\HasMany;
use Saham\SharedLibs\Traits\Translatable;

class Category extends BaseModel
{
    use HasFactory;
    use Translatable;
    use SoftDeletes ;

    protected $fillable = [
        'title_ar', 'title_en', 'icon', 'avatar', 'color_code', 'sorting', 'visibility',

    ];

    protected $translatable = ['title'];

    public function stores(): HasMany
    {
        return $this->hasMany(Store::class, 'id', 'category_id');
    }
}
