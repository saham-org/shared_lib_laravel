<?php

namespace Saham\SharedLibs\Models;

use Saham\SharedLibs\Mongodb\Eloquent\Model as Eloquent;
use Saham\SharedLibs\Mongodb\Query\Builder;
use Saham\SharedLibs\Mongodb\Relations\HasMany;
use Saham\SharedLibs\Traits\HasNotes;
use Saham\SharedLibs\Traits\HasOTPGrant;
use Saham\SharedLibs\Traits\HasPaymentTypes;
use Saham\SharedLibs\Traits\HasTransaction;
use Saham\SharedLibs\Traits\HasWallet;
use Saham\SharedLibs\Traits\Translatable;
use Illuminate\Auth\Authenticatable as AuthenticatableTrait;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Saham\SharedLibs\Database\Factories\UserFactory;

class User extends Eloquent implements Authenticatable
{
    use AuthenticatableTrait;
    use HasOTPGrant;
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use Translatable;
    use HasWallet;
    use HasTransaction;
    use HasPaymentTypes;
    use HasNotes ;

    protected $guarded = [];
    protected $with    = ['addresses'];

    protected $hidden = ['remember_token', 'otp'];

    protected $attributes = [
        'cuisine_ids' => [],
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $fillable = [
        'cuisine_ids', 'phone', 'otp', 'device_id', 'device_type', 'os_version', 'notification_id', 'email', 'allowed_payment_methods',
        'full_name', 'wallet', 'bank_iban' , 'bank_name' ,  'referral_code', 'notes_history' , 'block', 'password', 'gender'];

    protected static function newFactory()
    {
        return UserFactory::new();
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
        return $this->phone;
    }

    public function addresses(): HasMany
    {
        return $this->hasMany(Address::class);
    }

    public function delivers(): HasMany
    {
        return $this->hasMany(Deliver::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function feasts(): HasMany
    {
        return $this->hasMany(Feast::class);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    public function transactions(): Builder|HasMany
    {
        return $this->hasMany(UserTransaction::class)
            ->orderByDesc('created_at');
    }

    public function favorites(): EloquentBuilder|HasMany
    {
        return $this->hasMany(Favorite::class, 'user_id')->with('store');
    }

    public function generateToken(): string
    {
        return $this->createToken('saham Password Grant Client')->accessToken;
    }

    public function ratings(): HasMany
    {
        return $this->hasMany(Rating::class, 'user_id');
    }

    public function complains(): HasMany
    {
        return $this->hasMany(Complaint::class, 'related_id', '_id')->where('related_type', User::class);
    }

    public function cashoutMethods(): HasMany
    {
        return $this->hasMany(CashoutMethods::class, 'related_id', '_id')->where('related_type', User::class);
    }
}