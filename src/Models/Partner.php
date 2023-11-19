<?php

namespace Saham\SharedLibs\Models;

use Illuminate\Auth\Authenticatable as AuthenticatableTrait;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\HasApiTokens;
use Saham\SharedLibs\Mongodb\Eloquent\Model as Eloquent;
use Saham\SharedLibs\Mongodb\Relations\BelongsTo;
use Saham\SharedLibs\Mongodb\Relations\BelongsToArray;
use Saham\SharedLibs\Mongodb\Relations\HasMany;
use Saham\SharedLibs\Traits\HasNotes;
use Saham\SharedLibs\Traits\HasTransaction;
use Saham\SharedLibs\Traits\HasWallet;
use Saham\SharedLibs\Traits\Translatable;

class Partner extends Eloquent implements Authenticatable
{
    use AuthenticatableTrait;
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use Translatable;
    use HasWallet;
    use HasTransaction;
    use HasNotes;

    protected $translatable = ['company_name'];

    protected $guarded = [];
    protected $attributes = [
        'status' => 'under_revision',
        'cuisine_ids' => [],
    ];
    protected $hidden = ['remember_token', 'password'];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $fillable = [
        'full_name',
        'email',
        'phone',
        'custom_commission',
        'password',
        'category_id',
        'city_id',
        'bank_name',
        'bank_IBAN',
        'company_name_ar',
        'company_name_en',
        'commercial_ID',
        'logo',
        'cover',
        'language',
        'logo_thumb',
        'commercial_file',
        'account_status',
        'block',
        'status',
        'notification_id',
        'device_id',
        'device_type',
        'os_version',
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

    public function partnerInvoices(): HasMany
    {
        return $this->hasMany(PartnerInvoice::class);
    }

    public function modifier(): HasMany
    {
        return $this->hasMany(Modifier::class);
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

    public function cashoutMethods(): HasMany
    {
        return $this->hasMany(CashoutMethods::class, 'related_id', '_id')->where('related_type', Partner::class);
    }
}
