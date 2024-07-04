<?php

namespace Saham\SharedLibs\Models;

use Saham\SharedLibs\Traits\Translatable;
  use Saham\SharedLibs\Mongodb\Eloquent\Builder;
use Saham\SharedLibs\Models\Abstracts\BaseModel;
use Saham\SharedLibs\Mongodb\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
 use Saham\SharedLibs\Traits\HasNotes;
 
class CustomizedDeliveryFee extends BaseModel
{     
 
    use HasFactory;
    use SoftDeletes ;
    use Translatable;
    use HasNotes;
    
    protected $guarded = [];
    protected $table = 'customized_delivery_fees';
    protected $translatable = ['name'] ;

    
 

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    public function partner(): BelongsTo
    {
        return $this->belongsTo(Partner::class);
    }

    public function driver(): BelongsTo
    {
        return $this->belongsTo(Driver::class);
    }
  
}