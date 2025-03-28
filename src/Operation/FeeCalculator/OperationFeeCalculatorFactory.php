<?php

declare(strict_types=1);

namespace App\Operation\FeeCalculator;

use App\Operation\Operation;

class OperationFeeCalculatorFactory
{
    public static function createOperationFeeCalculator(Operation $operation): OperationFeeCalculatorInterface
    {
        return match ($operation->getOperationType()) {
            Operation::OPERATION_TYPE_DEPOSIT => new Deposit($operation),
            Operation::OPERATION_TYPE_WITHDRAW => self::createWithdrawFeeCalculator($operation),
            default => throw new \InvalidArgumentException("Unsupported operation type: {$operation->getOperationType()}"),
        };
    }

    private static function createWithdrawFeeCalculator(Operation $operation): OperationFeeCalculatorInterface
    {
        if ($operation->getUserType() === Operation::USER_TYPE_PRIVATE) {
            return new PrivateWithdraw($operation);
        }

        return new BusinessWithdraw($operation);
    }
}
