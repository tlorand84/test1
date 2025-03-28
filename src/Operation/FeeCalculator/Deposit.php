<?php

declare(strict_types=1);

namespace App\Operation\FeeCalculator;

use App\Operation\Operation;

class Deposit implements OperationFeeCalculatorInterface
{
    protected const FEE_PERCENTAGE = 0.03;

    public function __construct(private Operation $data)
    {
    }

    /**
     * Float value rounded up to 2 decimals.
     */
    public function calculateFee(): float
    {
        return ceil($this->data->getAmount() * static::FEE_PERCENTAGE) / 100;
    }
}
