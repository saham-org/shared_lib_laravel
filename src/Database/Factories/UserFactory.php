<?php

namespace Saham\SharedLibs\Database\Factories;

use Saham\SharedLibs\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
class UserFactory extends BaseFactory
{
    protected $model = User::class;


    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // 'id'                => Str::uuid()->getHex(),
            'name'              => $this->faker->name(),
            'email'             => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'phone'             => '+96650' . rand(00000000, 99999999), //$this->faker->phoneNumber(),
            'password'          => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            'remember_token'    => Str::random(10),
            'device_id'         => Str::random(10),
            'device_type'       => 'iphone',
            'notification_id'   => '',
            'os_version'        => '12.0',
            'bank_name'       => 'RJHI',
            'bank_IBAN'       => '0cb969c956c307a',
            'full_name'         => $this->faker->name(),
            'gender'            => 'male',
            'wallet'            => $this->faker->numberBetween(100, 1000),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function noWallet(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'wallet' => 0,
            ];
        });
    }

    public function withWallet(float $wallet)
    {
        return $this->state(function (array $attributes) use ($wallet) {
            return [
                'wallet' => $wallet,
            ];
        });
    }
}
