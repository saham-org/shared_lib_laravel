<?php

namespace Saham\SharedLibs\Database\Factories;

use Saham\SharedLibs\Models\Partner;
use MongoDB\Laravel\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\Factory;
use Saham\SharedLibs\Models\Store;

class StoreFactory extends BaseFactory
{
    protected $model = Store::class;

    public function definition()
    {
        return [
            'category_id'         => '62ab3479e407f1ab2e05df0d',
            //error  when using partner_id
            /*
            'partner_id'          => Partner::raw(function ($collection) {
                return $collection->aggregate([['$sample' => ['size' => 1]]]);
            })[0]->id,*/
            'name_ar'             => $this->faker->name(),
            'name_en'             => $this->faker->name(),
            'hotline'             => '+96650' . rand(00000000, 99999999), //$this->faker->phoneNumber(),
            'max_delivery_time'   => $this->faker->randomDigit(),
            'min_order_charge'    => 1,
            'logo'                => $this->faker->text(),
            'logo_thumb'          => $this->faker->text(),
            'commercial_photo'    => $this->faker->text(),
            'commercial_ID'       => $this->faker->text(),
            'latitude'            => $this->faker->latitude(),
            'longitude'           => $this->faker->longitude(),
            'avg_rating'          => $this->faker->randomFloat(1, $min = 4.0, $max = 4.9),
            'location'            => ['type' => 'Point', 'coordinates' => [-73.97, 40.77]],
            'wallet'              => 0,
            'services'            => getStoreServices($this, true),
        ];
    }

    public function forPartner(object $partner)
    {
        return $this->state(function (array $attributes) use ($partner) {
            return [
                'partner_id' => $partner->id,
            ];
        });
    }

    public function updateService(bool $service_status)
    {
        return $this->state(function (array $attributes) use ($service_status) {
            return [
                'services' => getStoreServices($this, $service_status),
            ];
        });
    }

    public function updatePaymentMethods(string $which, bool $flag)
    {
        return $this->state(function (array $attributes) use ($which, $flag) {
            $defaults = $attributes['accepts'];
            $defaults[$which] = $flag;
            $attributes['accepts'] = $defaults;
            return $attributes;
        });
    }
}
