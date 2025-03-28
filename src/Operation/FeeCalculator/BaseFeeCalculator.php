<?php

namespace App\Operation\FeeCalculator;

use App\Operation\Operation;

class BaseFeeCalculator implements OperationFeeCalculatorInterface
{
    protected const float FEE_PERCENTAGE = 0;

    public function __construct(protected Operation $operation)
    {
    }

    /**
     * Float value rounded up to 2 decimals.
     */
    public function calculateFee(): float
    {
        return ceil($this->getChargeableAmount() * static::FEE_PERCENTAGE) / 100;
    }

    protected function getChargeableAmount(): float
    {
        return $this->operation->getAmount();
    }
}
