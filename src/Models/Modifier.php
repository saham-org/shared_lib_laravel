<?php

namespace Saham\SharedLibs\Models;

use Saham\SharedLibs\Models\Abstracts\BaseModel;
use Saham\SharedLibs\Mongodb\Relations\BelongsTo;
use Saham\SharedLibs\Mongodb\Relations\EmbedsMany;
use Saham\SharedLibs\Traits\Translatable;

class Modifier  extends BaseModel
{
    use HasFactory;
    use Translatable;

    public $timestamps      = false;
    protected $translatable = ['title'];

    public function partner(): BelongsTo
    {
        return $this->belongsTo(Partner::class);
    }
}