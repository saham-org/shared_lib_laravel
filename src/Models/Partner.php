<?php

namespace SahamLibs\Models;

use SahamLibs\Mongodb\Eloquent\Model as Eloquent;
use SahamLibs\Mongodb\Relations\BelongsTo;
use SahamLibs\Mongodb\Relations\BelongsToArray;
use SahamLibs\Mongodb\Relations\HasMany;
use SahamLibs\Traits\HasTransaction;
use SahamLibs\Traits\HasWallet;
use SahamLibs\Traits\Translatable;
use Illuminate\Auth\Authenticatable as AuthenticatableTrait;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\HasApiTokens;

class Partner extends Eloquent implements Authenticatable
{
    use AuthenticatableTrait;
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use Translatable;
    use HasWallet;
    use HasTransaction;

    protected $translatable = ['company_name'];

    protected $guarded    = [];
    protected $attributes = [
        'status'      => 'under_revision',
        'cuisine_ids' => [],
    ];
    protected $hidden = ['remember_token', 'password'];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function setPasswordAttribute($value): void
    {
        $this->attributes['password'] = Hash::make($value);
    }

    public function findForPassport($username): ?self
    {
        return $this->where('phone', $username)->first();
    }

    public function routeNotificationForSms($notifiable): string
    {
        return $this->phone;
    }

    public function routeNotificationForFcm($notifiable): string
    {
        return $this->notification_id;
    }

    public function stores(): HasMany
    {
        return $this->hasMany(Store::class);
    }

    public function menus(): HasMany
    {
        return $this->hasMany(Menu::class);
    }

    public function cuisines(): BelongsToArray
    {
        return $this->belongsToArray(Cuisine::class, null, '_id', null, 'cuisine_ids');
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function payouts(): HasMany
    {
        return $this->hasMany(PartnerPayout::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function validateForPassportPasswordGrant($password): bool
    {
        return Hash::check($password, $this->password);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(PartnerTransaction::class)
            ->orderByDesc('created_at');
    }
}
