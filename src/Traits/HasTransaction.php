<?php

namespace Saham\SharedLibs\Traits;

use Saham\SharedLibs\Mongodb\Eloquent\Model;

trait HasTransaction
{
    public function createTrans(
        $type,
        $amount,
        $payment_id = null,
        $order_id = null,
        $store_id = null,
        $reason = null
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
            ]);
    }
}
