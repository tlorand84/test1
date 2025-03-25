<?php

namespace App\Service\OperationFeeCalculator;

interface OperationFeeCalculatorInterface
{
    public function execute(): float;
}