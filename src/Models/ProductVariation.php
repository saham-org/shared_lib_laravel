<?php

namespace Saham\SharedLibs\Models;

use Saham\SharedLibs\Models\Abstracts\BaseModel;
use Saham\SharedLibs\Mongodb\Relations\BelongsTo;
use Saham\SharedLibs\Mongodb\Relations\EmbedsMany;
use Saham\SharedLibs\Traits\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductVariation extends BaseModel
{
    use HasFactory;
    use Translatable;

    public $timestamps      = false;
    protected $translatable = ['title'];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function options(): EmbedsMany
    {
        return $this->embedsMany(VariationOption::class);
    }
}
