<?php

namespace Saham\SharedLibs\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Saham\SharedLibs\Models\Abstracts\BaseModel;
use MongoDB\Laravel\Relations\BelongsTo;
use MongoDB\Laravel\Relations\EmbedsMany;
use Saham\SharedLibs\Traits\Translatable;

class Modifier extends BaseModel
{
    use HasFactory;
    use Translatable;

    public $timestamps      = false;
    protected $translatable = ['title'];

    public function partner(): BelongsTo
    {
        return $this->belongsTo(Partner::class);
    }

    public function options(): EmbedsMany
    {
        return $this->embedsMany(ModifierOption::class);
    }
}
