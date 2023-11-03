<?php

namespace Saham\SharedLibs\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Saham\SharedLibs\Models\Partner;

class PartnerFactory extends BaseFactory
{
    protected $model = Partner::class;


    public function definition()
    {   //dd($this->faker->password()) ;
        return [
            'full_name'         => $this->faker->name(),
            'email'             => $this->faker->safeEmail(),
            'phone'             =>   '+96650' . rand(00000000, 99999999),//$this->faker->phoneNumber(),
            'category_id'       => 'null',
            'password'          => 123456789,
            'company_name_ar'   => $this->faker->text(),
            'company_name_en'   => $this->faker->text(),
            'language'          => 'ar',
            'device_id'         => '067E7A0F-B064-4134-B562-4CF85FCFCC4D',
            'device_type'       => 'iphone',
            'bank_name'       => 'RJHI',
            'bank_IBAN'       => '0cb969c956c307a',
            'os_version'        => '15.5',
            'notification_id'   => '0cb969c956c307aaf8f585a0cc248a4f1506cb90edeea7922ca70fb1a334c0bd',

        ];
    }

    public function customCommission(float $commission)
    {
        return $this->state(function (array $attributes) use ($commission) {
            return [
                'custom_commission' => $commission,
            ];
        });
    }

    public function forStatusAcount(string $status)
    {
        /*    return $this->state(function (array $attributes) use ($status) {
                return [
                    'account_status' => $status,
                ];
            });*/
    }

    public function withWallet(float $balance)
    {
        return $this->state(function (array $attributes) use ($balance) {
            return [
                'wallet' => $balance,
            ];
        });
    }
}
