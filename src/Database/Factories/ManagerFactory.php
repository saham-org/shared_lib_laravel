<?php

namespace Saham\SharedLibs\Database\Factories;

use Saham\SharedLibs\Models\Manager;
use Saham\SharedLibs\Models\Store;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Manager>
 */
class ManagerFactory extends BaseFactory
{
    public function definition()
    {
        $phone =  '+96650' . rand(00000000, 99999999);

        return [
            'full_name'         => $this->faker->name(),
            'email'             => $this->faker->unique()->safeEmail(),
            'phone'             => $phone, //$this->faker->unique()->phoneNumber(),
            'email_verified_at' => now(),
            'password'          => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token'    => Str::random(10),
            'status'            => 'active',
            'device_id'         => $this->faker->uuid(),
            'notification_id'   => $this->faker->uuid(),
            'store_id'          => null,
        ];
    }

    public function withStore(Store $store)
    {
        return $this->state(function (array $attributes) use ($store) {
            return [
                'store_id' => $store->id,
            ];
        });
    }
}
