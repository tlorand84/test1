<?php

declare(strict_types=1);

namespace App\Operation\FeeCalculator;

interface OperationFeeCalculatorInterface
{
    public function calculateFee(): float;
}
