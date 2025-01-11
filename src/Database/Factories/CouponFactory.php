<?php

namespace Saham\SharedLibs\Database\Factories;

use Saham\SharedLibs\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use MongoDB\BSON\UTCDateTime;
use Saham\SharedLibs\Models\Coupon;

/**
 * @extends Factory<User>
 */
class CouponFactory extends BaseFactory
{
    protected $model = Coupon::class;



    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'                => $this->faker->name(),
            'partner_ids'         => [
                'all',
            ],
            'type_discount'       => 'percentage',
            'amount'              => $this->faker->numberBetween(1, 99),
            'code'                => $this->faker->word() . $this->faker->numberBetween(1, 99),
            'users_id'            => [
                'all',
            ],
            'users_date_range'    => [
                'start' => (Carbon::now()->subDays(10)->format('Uv')),
                'end'   => (Carbon::now()->addDays(10)->format('Uv')),
            ],
            'promo_date_range'    => [
                'start' => (Carbon::now()->subDays(10)->format('Uv')),
                'end'   => (Carbon::now()->addDays(10)->format('Uv')),
            ],
            'limit_per_user'      => $this->faker->numberBetween(10, 99),
            'global_limit'        => $this->faker->numberBetween(10, 99),
            'radius'              => $this->faker->numberBetween(10, 99),
            'latitude'            => '26.3624931',
            'longitude'           => '49.8524557',
            'minimum_amount'      => $this->faker->numberBetween(0, 1),
            'updated_at'          => Carbon::now()->format('Uv'),
            'created_at'          => Carbon::now()->format('Uv'),

        ];
    }

    public function forAllUsers()
    {
        return $this->state(function (array $attributes) {
            return [
                'users_id' => ['all'],
            ];
        });
    }

    public function forNoUsers()
    {
        return $this->state(function (array $attributes) {
            return [
                'users_id' => [],
            ];
        });
    }

    public function forUsers(array $userIDs)
    {
        return $this->state(function (array $attributes) use ($userIDs) {
            return [
                'users_id' => $userIDs,
            ];
        });
    }

    public function forDateRange($start, $end)
    {
        return $this->state(function (array $attributes) use ($start, $end) {
            return [
                'promo_date_range' => [
                    'start' => $start,
                    'end'   => $end,
                ],
            ];
        });
    }

    public function appliedAmount(float $amount)
    {
        return $this->state(function (array $attributes) use ($amount) {
            return [
                'amount' => $amount,
            ];
        });
    }

    public function forPartners(array $partnerIDs)
    {
        return $this->state(function (array $attributes) use ($partnerIDs) {
            return [
                'partner_ids' => $partnerIDs,
            ];
        });
    }

    public function forNoPartner()
    {
        return $this->state(function (array $attributes) {
            return [
                'partner_ids' => [],
            ];
        });
    }

    public function withGlobalUse(float $number)
    {
        return $this->state(function (array $attributes) use ($number) {
            return [
                'global_use' => $number,
            ];
        });
    }

    public function withGlobalLimit(float $number)
    {
        return $this->state(function (array $attributes) use ($number) {
            return [
                'global_limit' => $number,
            ];
        });
    }

    public function withLimitPerUser(float $number)
    {
        return $this->state(function (array $attributes) use ($number) {
            return [
                'limit_per_user' => $number,
            ];
        });
    }

    public function updateUsedArray(array $usedArray)
    {
        return $this->state(function (array $attributes) use ($usedArray) {
            return [
                'used_by' => $usedArray,
            ];
        });
    }
}
