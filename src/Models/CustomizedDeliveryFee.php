<?php

namespace Saham\SharedLibs\Models;

use Saham\SharedLibs\Traits\HasNotes;
use Saham\SharedLibs\Traits\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Saham\SharedLibs\Models\Abstracts\BaseModel;
use Saham\SharedLibs\Mongodb\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CustomizedDeliveryFee extends BaseModel
{
    use HasFactory;
    use SoftDeletes ;
    use Translatable;
    use HasNotes;

    protected $guarded      = [];
    protected $table        = 'customized_delivery_fees';
    protected $translatable = ['name'] ;
    protected $dates        = ['deleted_at'];



    public function isForPartner(string $partner_id): bool
    {
        if ($this->partner_ids && is_array($this->partner_ids)) {
            return in_array('all', $this->partner_ids, true) || in_array($partner_id, $this->partner_ids, true);
        }

        return true;
    }

    public function isForStore(string $store_id): bool
    {
        $store = Store::find($store_id);

        if (empty($store)) {
            return false;
        }

        if ($this->partner_ids && is_array($this->partner_ids)) {
            return in_array('all', $this->partner_ids, true) || in_array($store->partner_id, $this->partner_ids, true);
        }

        return false;
    }
}
