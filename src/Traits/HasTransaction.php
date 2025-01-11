<?php

namespace Saham\SharedLibs\Traits;

use MongoDB\Laravel\Eloquent\Model;

trait HasTransaction
{
    public function createTrans(
        $type,
        $amount,
        $payment_id = null,
        $order_id = null,
        $store_id = null,
        $reason = null,
        $tag_id = null ,
        $reward_id = null
    ): ?Model {
        if ($amount < 0) {
            $type = 'withdraw';
        }

        return $this->transactions()
            ->create([
                'ref_id'       => (string) uniqueCode(),
                'amount'       => abs($amount),

                'type'         => $type,
                'payment_id'   => $payment_id,
                'order_id'     => $order_id,
                'store_id'     => $store_id,
                'reason'       => $reason ?? '',
                'tag_id'       => $tag_id ?? '',
                'reward_id'    => $reward_id ?? '',     
            ]);
    }
}
