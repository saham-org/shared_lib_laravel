<?php

namespace Saham\SharedLibs\Database\Factories;

use Saham\SharedLibs\Models\Driver;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Driver>
 */
class DriverFactory extends BaseFactory
{
    protected $model = Driver::class;


    public function definition()
    {
        $latitude = '30.0294578' ;//$this->faker->latitude();
        $longitude = '31.5255809,15' ;//$this->faker->longitude();
        $phone =  '+96650' . rand(00000000, 99999999);
        return [
            'name'              => $this->faker->name(),
            'email'             => $this->faker->unique()->safeEmail(),
            'phone'             => $phone ,
            'email_verified_at' => now(),
            'password'          => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token'    => Str::random(10),
            'status'            => 'active',
            'latitude'          => $latitude,
            'longitude'         => $longitude,
            'device_id'         => $this->faker->uuid(),
            'notification_id'   => $this->faker->uuid(),
            'wallet'            => 0,
            'bank_name'       => 'RJHI',
            'bank_IBAN'       => '0cb969c956c307a',
            'location'            => ['type' => 'Point', 'coordinates' => [-73.97, 40.77]],
            /*'location'          => [
                'type'        => 'Point',
                'coordinates' => [
                    "{$latitude}",
                    "{$longitude}",
                ],
            ],*/


        ];
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
