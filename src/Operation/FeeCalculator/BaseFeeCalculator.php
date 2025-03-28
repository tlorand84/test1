<?php

namespace App\Operation\FeeCalculator;

use App\Operation\Operation;

class BaseFeeCalculator implements OperationFeeCalculatorInterface
{
    protected const FEE_PERCENTAGE = 0;

    public function __construct(protected Operation $operation)
    {
    }

    /**
     * Float value rounded up to 2 decimals.
     */
    public function calculateFee(): float
    {
        return ceil($this->operation->getAmount() * static::FEE_PERCENTAGE) / 100;
    }
}
