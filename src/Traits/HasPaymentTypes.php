<?php

namespace Saham\SharedLibs\Traits;

/**
 * Trait HasRoles.
 */
trait HasPaymentTypes
{
    public function allowedPaymentMethodAtName(): string
    {
        return 'allowed_payment_methods';
    }

    public function getPaymentTypesAttribute(): mixed
    {
        return getSystemPaymentMethods(collect($this->{$this->allowedPaymentMethodAtName()})->toArray() ?? []);
    }

    public function paymentTypes(): mixed
    {
        return $this->getPaymentTypesAttribute();
    }

    public function canPerformPaymentType(string $paymentType): bool
    {
        return $this->paymentTypes()[$paymentType] ?? false;
    }

    public function bulkUpdatePaymentTypes(array $paymentTypes): void
    {
        $this->{$this->allowedPaymentMethodAtName()} = $paymentTypes;
        $this->save();
    }

    public function updateSinglePaymentType(string $paymentType, bool $value): void
    {
        $paymentTypes = $this->paymentTypes();
        $paymentTypes[$paymentType] = $value;

        $this->bulkUpdatePaymentTypes($paymentTypes);
    }
}
