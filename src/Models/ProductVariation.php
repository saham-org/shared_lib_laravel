<?php

namespace SahamLibs\Models;

use SahamLibs\Models\Abstracts\BaseModel;
use SahamLibs\Mongodb\Relations\BelongsTo;
use SahamLibs\Mongodb\Relations\EmbedsMany;
use SahamLibs\Traits\Translatable;
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
