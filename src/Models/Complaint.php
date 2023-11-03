<?php

namespace Saham\SharedLibs\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Saham\SharedLibs\Models\Abstracts\BaseModel;
use Saham\SharedLibs\Mongodb\Relations\BelongsTo;
use Saham\SharedLibs\Traits\Translatable;

class Complaint extends BaseModel
{
    use HasFactory;
    use Translatable;

    protected array $translatable = ['name'];
    protected $table              = 'complaints';
    protected $fillable           = ['order_id', 'related_id', 'related_type', 'store_id', 'complaint_type_id', 'comments', 'description', 'status', 'files'];

    public function setFileComplaintAttribute($value, $type = 'driver'): void
    {
        $this->attributes['file_complaint'] = storeImage($value, $type, 'complaint');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function driver(): BelongsTo
    {
        return $this->belongsTo(Driver::class, 'driver_id');
    }

    public function related(): BelongsTo
    {
        return $this->belongsTo(Driver::class, 'related_id');
    }

    public function typeComplaint(): BelongsTo
    {
        return $this->belongsTo(ComplaintType::class, 'complaint_type_id');
    }
}
