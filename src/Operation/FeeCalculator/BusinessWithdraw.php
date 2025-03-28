<?php

declare(strict_types=1);

namespace App\Operation\FeeCalculator;

use App\Operation\Operation;

class BusinessWithdraw implements OperationFeeCalculatorInterface
{
    public function __construct(private Operation $data)
    {
    }

    public function calculateFee(): float
    {
        throw new \Exception('Not implemented yet');
    }
}
