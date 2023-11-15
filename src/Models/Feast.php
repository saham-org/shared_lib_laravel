<?php

namespace Saham\SharedLibs\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Saham\SharedLibs\Mongodb\Relations\BelongsTo;
use Saham\SharedLibs\Mongodb\Relations\HasMany;
use Saham\SharedLibs\StateMachines\FeastStatusMachine;
use Saham\SharedLibs\Traits\HasNotes;
use Saham\SharedLibs\Traits\HasStateMachines;
use Saham\SharedLibs\Models\Abstracts\BaseModel;
use Saham\SharedLibs\Models\Enums\FeastStatus;
use Saham\SharedLibs\Mongodb\Eloquent\Builder;

class Feast extends Order
{
    use HasFactory;
    use HasNotes;
    use HasStateMachines;

    /**
     * `status` State Machines
     * @var array
     */
    public $stateMachines = [
        'status' => FeastStatusMachine::class
    ];
    protected $guarded = [];
    protected $table = 'feasts';

    public function details(): HasMany
    {
        return $this->hasMany(FeastDetails::class);
    }

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

    public function complaints(): HasMany
    {
        return $this->hasMany(Complaint::class, 'feast_id');
    }

    public function ratings(): HasMany
    {
        return $this->hasMany(Rating::class, 'feast_id');
    }

    public function complains(): HasMany
    {
        return $this->hasMany(Complaint::class);
    }

    public function userFeastTransaction(): HasMany
    {
        return $this->hasMany(UserTransaction::class, 'feast_id');
    }
}
