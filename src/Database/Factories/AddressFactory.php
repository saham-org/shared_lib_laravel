<?php

namespace Saham\SharedLibs\Database\Factories;

use Saham\SharedLibs\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Saham\SharedLibs\Models\Address;

class AddressFactory extends BaseFactory
{
    protected $model = Address::class;



    public function definition()
    {
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
