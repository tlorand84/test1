<?php

namespace App\Service\OperationFeeCalculator;

class PrivateWithdrawOperation implements OperationInterface
{
    public function __construct(private OperatorInterface $data)
    {
    }

    public function execute(): float
    {
        throw new \Exception('Not implemented yet');
    }
}