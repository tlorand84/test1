<?php

declare(strict_types=1);

namespace App\Operation\FeeCalculator;

use App\Operation\Operation;

class OperationFeeCalculatorFactory
{
    public static function createOperationFeeCalculator(Operation $data): OperationFeeCalculatorInterface
    {
        return match ($data->getOperationType()) {
            Operation::OPERATION_TYPE_DEPOSIT => new Deposit($data),
            Operation::OPERATION_TYPE_WITHDRAW => self::createWithdrawFeeCalculator($data),
            default => throw new \InvalidArgumentException("Unsupported operation type: {$data->getOperationType()}"),
        };
    }

    private static function createWithdrawFeeCalculator(Operation $data): OperationFeeCalculatorInterface
    {
        if ($data->getUserType() === Operation::USER_TYPE_PRIVATE) {
            return new PrivateWithdraw($data);
        }

        return new BusinessWithdraw($data);
    }
}
