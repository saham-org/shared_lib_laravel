<?php

namespace Saham\SharedLibs\Database\Factories;

use Saham\SharedLibs\Models\Enums\FeastStatus;
use Saham\SharedLibs\Models\Feast;
use Saham\SharedLibs\Models\Partner;
use Saham\SharedLibs\Models\Store;

class FeastFactory extends BaseFactory
{
    protected $model = Feast::class;


    public function definition()
    {
        $sub_total   = $this->faker->numberBetween(50, 100);
        $total       =   $sub_total;
        $vat         =  round($sub_total * 15 / 100, 2);

        return [
            'status'       => 'pending',
            'feast_type'       => 'dinner',
            'cash_paid'       => false,
            'ref_id'       => $this->faker->uuid(),
            'notes'        => "feast details",
            'coupon'       => null,
            'payment_type' => 'cash',
            'payment_id'   => $this->faker->uuid(),
            'type'         => null,
            'deliver_type' => 'delivery',
            'latitude'     => $this->faker->latitude(),
            'longitude'    => $this->faker->longitude(),
            'delivery_fee' => null,
            'driver_id'    => null,
            'partner_id'   => null,
            'sub_total'    => $sub_total,
            'total'        => $total,
            'vat'          => $vat,
            'user_id'      => null,
            'delivery_date'   => now(),
            'updated_at'   => now(),
            'created_at'   => now(),
        ];
    }

    public function forPartner(Partner $partner): ?self
    {
        return $this->state(function (array $attributes) use ($partner) {
            return [
                'partner_id' => $partner->id,
            ];
        });
    }

    public function forUser(object $user): ?self
    {
        return $this->state(function (array $attributes) use ($user) {
            return [
                'user_id' => $user->id,
            ];
        });
    }


    public function forStore(Store $store): ?self
    {
        return $this->state(function (array $attributes) use ($store) {
            return [
                'store_id' => $store->id,
            ];
        });
    }

    public function updateStatus(FeastStatus $status)
    {
        return $this->state(function (array $attributes) use ($status) {
            return [
                'status' => &$status->value,
            ];
        });
    }

    public function deliverType(string $type): ?self
    {
        return $this->state(function (array $attributes) use ($type) {
            if ($type === 'receipt') {
                return [
                    'total' => $attributes['total'] - $attributes['delivery_fee'],
                    'deliver_type'  => 'receipt',
                    'driver_id'     => null,
                    'delivery_fee'  => 0,
                ];
            } else {
                return [
                    'deliver_type' => $type,
                ];
            }
        });
    }

    public function paymentType(string $type): ?self
    {
        return $this->state(function (array $attributes) use ($type) {
            return [
                'payment_type' => $type,
            ];
        });
    }
}
