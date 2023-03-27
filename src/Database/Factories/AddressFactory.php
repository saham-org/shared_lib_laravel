<?php

namespace Saham\SharedLibs\Database\Factories;

use Saham\SharedLibs\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AddressFactory extends Factory
{
    public function definition()
    {
        $faker_ar = \Faker\Factory::create('ar_AR');
        return [
            'latitude'  => $this->faker->latitude(),
            'longitude' => $this->faker->longitude(),
            'type'      => 'home',
        ];
    }


    public function forUser(User $user): ?self
    {
        return $this->state(function (array $attributes) use ($user) {
            return [
                'user_id' => $user->id,
            ];
        });
    }
}
