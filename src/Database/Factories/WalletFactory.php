<?php

namespace Saham\SharedLibs\Database\Factories;

use Saham\SharedLibs\Models\Manager;
use Saham\SharedLibs\Models\Store;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Saham\SharedLibs\Models\Wallet;
use Saham\SharedLibs\Models\User;

class WalletFactory extends BaseFactory
{
    protected $model = Wallet::class;

    public function definition()
    {
        return [
            'wallet'  => (float) 999999,
        ];
    }

    public function withUser(User $user)
    {
        return $this->state(function (array $attributes) use ($user) {
            return [
                'user_id' => (string) $user->_id,
            ];
        });
    }
}
