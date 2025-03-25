<?php

namespace App\Service\OperationFeeCalculator;

use App\Service\OperationFeeCalculator\OperationConstants;
use App\Service\OperationFeeCalculator\OperatorInterface;

class OperationFactory
{
    public static function createOperation(OperatorInterface $data): OperationInterface
    {
        return match ($data->getOperationType()) {
            OperationConstants::OPERATION_TYPE_DEPOSIT => new DepositOperation($data),
            OperationConstants::OPERATION_TYPE_WITHDRAW => self::createWithdrawOperation($data),
            default => throw new \InvalidArgumentException("Unsupported operation type: {$data->getOperationType()}"),
        };
    }

    private static function createWithdrawOperation(OperatorInterface $data): OperationInterface
    {
        if ($data->getUserType() === OperationConstants::USER_TYPE_PRIVATE) {
            return new PrivateWithdrawOperation($data);
        }

        return new BusinessWithdrawOperation($data);
    }
}